<?php

namespace Rubix\ML\Tests\NeuralNet\CostFunctions;

use Tensor\Tensor;
use Tensor\Vector;
use Tensor\Matrix;
use Rubix\ML\NeuralNet\CostFunctions\RelativeEntropy;
use Rubix\ML\NeuralNet\CostFunctions\CostFunction;
use PHPUnit\Framework\TestCase;
use Generator;

class RelativeEntropyTest extends TestCase
{
    /**
     * @var \Rubix\ML\NeuralNet\CostFunctions\RelativeEntropy
     */
    protected $costFn;

    public function setUp() : void
    {
        $this->costFn = new RelativeEntropy();
    }

    public function test_build_cost_function() : void
    {
        $this->assertInstanceOf(RelativeEntropy::class, $this->costFn);
        $this->assertInstanceOf(CostFunction::class, $this->costFn);
    }

    /**
     * @param \Tensor\Matrix $output
     * @param \Tensor\Matrix $target
     * @param float $expected
     *
     * @dataProvider compute_provider
     */
    public function test_compute(Matrix $output, Matrix $target, float $expected) : void
    {
        $loss = $this->costFn->compute($output, $target);

        $this->assertEquals($expected, $loss);
    }

    /**
     * @return \Generator
     */
    public function compute_provider() : Generator
    {
        yield [
            Matrix::quick([[0.99, 0.01, 0.]]),
            Matrix::quick([[1., 0., 0.]]),
            0.003350065899465309,
        ];

        yield [
            Matrix::quick([[0.2, 0.4, 0.4]]),
            Matrix::quick([[0., 1., 0.]]),
            0.3054301295726089,
        ];

        yield [
            Matrix::quick([[0.0, 0.1, 0.9]]),
            Matrix::quick([[1., 0., 0.]]),
            6.140226799872736,
        ];

        yield [
            Matrix::quick([
                [0.2, 0.1, 0.7],
                [0.0, 0.9, 0.1],
                [0.1, 0.3, 0.6],
            ]),
            Matrix::quick([
                [0.0, 0.0, 1.0],
                [0.0, 1.0, 0.0],
                [0.0, 0.0, 1.0],
            ]),
            0.10809558439335247,
        ];
    }

    /**
     * @param \Tensor\Tensor $output
     * @param \Tensor\Tensor $target
     * @param array[] $expected
     *
     * @dataProvider differentiate_provider
     */
    public function test_differentiate(Tensor $output, Tensor $target, array $expected) : void
    {
        $gradient = $this->costFn->differentiate($output, $target)->asArray();

        $this->assertEquals($expected, $gradient);
    }

    /**
     * @return \Generator
     */
    public function differentiate_provider() : Generator
    {
        yield [
            Vector::quick([0.99, 0.01, 0.]),
            Vector::quick([1., 0., 0.]),
            [-0.01010101010101011, 0.999999, 0.],
        ];

        yield [
            Vector::quick([0.2, 0.4, 0.4]),
            Vector::quick([0., 1., 0.]),
            [0.9999999500000001, -1.4999999999999998, 0.999999975],
        ];

        yield [
            Vector::quick([0.0, 0.1, 0.9]),
            Vector::quick([1., 0., 0.]),
            [-99999999.0, 0.9999999, 0.9999999888888889],
        ];

        yield [
            Matrix::quick([
                [0.2, 0.1, 0.7],
                [0.0, 0.9, 0.1],
                [0.1, 0.3, 0.6],
            ]),
            Matrix::quick([
                [0.0, 0.0, 1.0],
                [0.0, 1.0, 0.0],
                [0.0, 0.0, 1.0],
            ]),
            [
                [0.9999999500000001, 0.9999999, -0.42857142857142866],
                [0., -0.11111111111111108, 0.9999999],
                [0.9999999, 0.9999999666666667, -0.6666666666666667],
            ],
        ];
    }
}
