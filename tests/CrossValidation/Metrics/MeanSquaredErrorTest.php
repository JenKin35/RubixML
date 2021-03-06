<?php

namespace Rubix\ML\Tests\CrossValidation\Metrics;

use Rubix\ML\CrossValidation\Metrics\Metric;
use Rubix\ML\CrossValidation\Metrics\MeanSquaredError;
use PHPUnit\Framework\TestCase;
use Generator;

class MeanSquaredErrorTest extends TestCase
{
    /**
     * @var \Rubix\ML\CrossValidation\Metrics\MeanSquaredError
     */
    protected $metric;

    public function setUp() : void
    {
        $this->metric = new MeanSquaredError();
    }

    public function test_build_metric() : void
    {
        $this->assertInstanceOf(MeanSquaredError::class, $this->metric);
        $this->assertInstanceOf(Metric::class, $this->metric);

        $this->assertNotEmpty(array_filter($this->metric->range(), 'is_numeric'));
        $this->assertNotEmpty(array_filter($this->metric->compatibility(), 'is_int'));
    }

    /**
     * @dataProvider score_provider
     */
    public function test_score(array $predictions, array $labels, float $expected) : void
    {
        [$min, $max] = $this->metric->range();

        $score = $this->metric->score($predictions, $labels);

        $this->assertThat(
            $score,
            $this->logicalAnd(
                $this->greaterThanOrEqual($min),
                $this->lessThanOrEqual($max)
            )
        );

        $this->assertEquals($expected, $score);
    }

    public function score_provider() : Generator
    {
        yield [
            [7, 9.5, -20, -500, .079],
            [10, 10.0, 6, -1400, .08],
            -162137.0500002,
        ];

        yield [
            [0, 0, 0, 0, 0],
            [10, 10.0, 6, -1400, .08],
            -392047.20128000004,
        ];

        yield [
            [10, 10.0, 6, -1400, .08],
            [10, 10.0, 6, -1400, .08],
            0.0,
        ];
    }
}
