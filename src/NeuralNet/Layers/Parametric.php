<?php

namespace Rubix\ML\NeuralNet\Layers;

use Generator;

interface Parametric extends Nonparametric
{
    /**
     * Return the parameters of the layer.
     *
     * @return \Generator
     */
    public function parameters() : Generator;

    /**
     * Return the parameters of the layer in an associative array.
     *
     * @return \Rubix\ML\NeuralNet\Parameters\Parameter[]
     */
    public function read() : array;

    /**
     * Restore the parameters in the layer from an associative array.
     *
     * @param array $parameters
     */
    public function restore(array $parameters) : void;
}
