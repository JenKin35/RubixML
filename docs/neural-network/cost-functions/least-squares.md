<span style="float:right;"><a href="https://github.com/RubixML/RubixML/blob/master/src/NeuralNet/CostFunctions/LeastSquares.php">[source]</a></span>

# Least Squares
Least Squares (or *quadratic* loss) is a function that computes the average squared error (MSE) between the target output given by the labels and the actual output of the network. It produces a smooth bowl-shaped gradient that is highly-influenced by large errors.

### Parameters
This cost function does not have any parameters.

### Example
```php
use Rubix\ML\NeuralNet\CostFunctions\LeastSquares;

$costFunction = new LeastSquares();
```