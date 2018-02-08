<?php

namespace ChrisKonnertz\RegEx\Expressions;

use ChrisKonnertz\RegEx\RegEx;
use Closure;

/**
 * This is the abstract base class for all expression classes.
 * The concrete expression class has to overwrite the toString() method.
 * It may have to overwrite the validate() method as well.
 */
abstract class AbstractExpression
{

    /**
     * Array with all partial expressions (at least one) of the overall expression.
     * Valid types of the array values are: string|int|float|AbstractExpression
     *
     * @var array
     */
    protected $expressions;

    /**
     * Constructor of the abstract expression class.
     *
     * @param string|int|float|AbstractExpression ...$expressions The partial expressions
     */
    public function __construct(...$expressions)
    {
        $this->setExpressions($expressions);
    }

    /**
     * Validates the partial expressions that are passed to the constructor of the concrete class.
     * Valid types of the array values are: string|int|float|AbstractExpression
     * Feel free to override this method if you need enhanced validation.
     *
     * @param array $expressions
     * @return void
     * @throws \Exception
     */
    public function validate(array $expressions)
    {
        if (count($expressions) === 0) {
            throw new \InvalidArgumentException(
                'You have to pass at least one argument to the constructor of an object of type"'.gettype($this).'".'
            );
        }

        foreach ($expressions as $index => $expression) {
            if (! (is_string($expression) or is_int($expression) or is_float($expression) or $expression instanceof AbstractExpression)) {
                throw new \InvalidArgumentException('Type of the '.($index + 1).'. passed partial expression is invalid.');
            }
        }
    }

    /**
     * Setter for the expressions array
     *
     * @param array $expressions
     */
    public function setExpressions(array $expressions)
    {
        $this->validate($expressions);

        foreach ($expressions as &$expression) {
            if (! $expression instanceof AbstractExpression) {
                /** @see http://php.net/manual/en/function.preg-quote.php */
                $expression = preg_quote($expression, RegEx::DELIMITER);
            }
        }

        $this->expressions = $expressions;
    }

    /**
     * Call this method if you want to traverse it and all of it child expression,
     * no matter how deep they are nested in the tree. You only have to pass a closure,
     * you do not have to pass an argument for the level parameter.
     * The callback will have three arguments: The first is the child expression
     * (an object of type AbstractExpression or a string | int | float),
     * the second is the level of the that expression and the third tells you if
     * it has children.
     *
     * Example:
     *
     * $expression->traverse(function($expression, int $level, bool $hasChildren)
     * {
     *     var_dump($expression, $level, $hasChildren);
     * });
     *
     * @param Closure $callback A callback function
     * @param int     $level    The current level - starting at 0
     * @return void
     */
    public function traverse(Closure $callback, int $level = 0)
    {
        $callback($this, $level, true);

        foreach ($this->expressions as $expression) {
            if ($expression instanceof AbstractExpression) {
                $expression->traverse($callback, $level + 1);
            } else {
                $callback($expression, $level + 1, false);
            }
        }
    }

    /**
     * Removes all expressions.
     *
     * @return void
     */
    public function clear()
    {
        $this->expressions = [];
    }

    /**
     * Getter for the partial expressions array
     *
     * @return array
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    /**
     * Returns the number of partial expressions.
     * If $recursive is false, only the partial expressions on the root level are counted.
     * If $recursive is true, the method traverses trough all partial expressions and counts
     * all partial expressions without sub expressions. Or with other words: If you visualize
     * the regular expression as a tree then this method will only count its leaves.
     *
     * @param bool $recursive If true, also count nested expressions
     * @return int
     */
    public function getSize($recursive = true) : int
    {
        if ($recursive) {
            $size = 0;

            $this->traverse(function($expression, int $level, bool $hasChildren) use (&$size)
            {
                if (! $hasChildren) {
                    $size++;
                }
            });

            return $size;
        } else {
            return sizeof($this->expressions);
        }
    }

    /**
     * Returns the complete regular expression as a string.
     * The concrete expression class has to implement this class.
     *
     * @return string
     */
    abstract public function toString();

    /**
     * This PHP magic method returns the complete regular expression as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
