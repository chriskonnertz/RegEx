<?php

namespace ChrisKonnertz\RegExMaker;

use ChrisKonnertz\RegExMaker\Expressions\AbstractExpression;
use Closure;

/**
 * This is the RegExMaker base class. It is the API frontend of the RegExMaker library.
 * Call its add<Something>() methods to add partial expressions.
 * Finally call its toString() method to retrieve the complete regular expression as a string.
 */
class RegExMaker
{

    /**
     * The current version number
     */
    const VERSION = '0.5.0';

    /**
     * The start of the regular expression
     *
     * @var string
     */
    protected $start = '/';

    /**
     * Array with all partial expressions
     *
     * @var AbstractExpression[]
     */
    protected $expressions = [];

    /**
     * Then end of the regular expression
     *
     * @var string
     */
    protected $end = '/';
    
    /**
     * Add a partial expression to the overall regular expression and wrap it in an "and" expression.
     * This expression requires that all of it parts exist in the tested string.
     * TODO Add examples
     *
     * @param string|int|float|Closure|AbstractExpression $partialExpressions
     * @return self
     */
    public function addAnd(...$partialExpressions)
    {
        foreach ($partialExpressions as &$partialExpression) {
            if ($partialExpression instanceof Closure) {
                $partialExpression = $partialExpression($this);
            }
        }

        $wrapperExpression = new Expressions\AndEx(...$partialExpressions);
        $this->expressions[] = $wrapperExpression;

        return $this;
    }

    /**
     * Add at least two partial expressions to the overall regular expression and wrap it in an "or" expression.
     * This expression requires that one of it parts exists in the tested string.
     * TODO Add examples
     *
     * @param string|int|float|Closure|AbstractExpression $values
     * @return self
     */
    public function addOr(...$partialExpressions)
    {
        foreach ($partialExpressions as &$partialExpression) {
            if ($partialExpression instanceof Closure) {
                $partialExpression = $partialExpression($this);
            }
        }

        $wrapperExpression = new Expressions\OrEx(...$partialExpressions);
        $this->expressions[] = $wrapperExpression;

        return $this;
    }

    /**
     * Add one ore more partial expressions to the overall regular expression and wrap them in an "optional" expression.
     * The parts of this expression may or may not exist in the tested string.
     * TODO Add examples
     *
     * @param string|int|float|Closure|AbstractExpression $values
     * @return self
     */
    public function addOption(...$partialExpressions)
    {
        foreach ($partialExpressions as &$partialExpression) {
            if ($partialExpression instanceof Closure) {
                $partialExpression = $partialExpression($this);
            }
        }

        $wrapperExpression = new Expressions\OptionEx(...$partialExpressions);
        $this->expressions[] = $wrapperExpression;

        return $this;
    }

    /**
     * Add one ore more partial expressions to the overall regular expression and wrap them in a "raw" expression.
     * This expression will not quote its regular expression characters.
     * TODO Add examples
     *
     * @param string|int|float|Closure|AbstractExpression $values
     * @return self
     */
    public function addRaw(...$partialExpressions)
    {
        foreach ($partialExpressions as &$partialExpression) {
            if ($partialExpression instanceof Closure) {
                $partialExpression = $partialExpression($this);
            }
        }

        $wrapperExpression = new Expressions\RawEx(...$partialExpressions);
        $this->expressions[] = $wrapperExpression;

        return $this;
    }

    /**
     * Tests a given subject against the regular expression.
     * Returns the matches.
     *
     * @param string $subject
     * @return array
     */
    public function test(string $subject)
    {
        $regEx = $this->toString();

        $matches = [];

        preg_match($regEx, $subject, $matches);

        return $matches;
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
     * $regExMaker->traverse(function(Closure $expression, int $level, bool $hasChildren)
     * {
     *     var_dump($expression, $level, $hasChildren);
     * });
     *
     * @param Closure $callback
     */
    public function traverse(Closure $callback)
    {
        foreach ($this->expressions as $expression) {
            $expression->traverse($callback);
        }
    }

    /**
     * Removes all partial expressions.
     *
     * @return self
     */
    public function clear()
    {
        $this->expressions = [];

        return $this;
    }

    /**
     * Returns the number of partial expressions
     *
     * @return int
     */
    public function getSize()
    {
        return sizeof($this->expressions);
    }

    /**
     * Getter for the partial expressions array
     *
     * @return AbstractExpression[]
     */
    public function getExpressions()
    {
        return $this->expressions;
    }
    
    /**
     * Returns the concatenated partial regular expressions as a string
     * 
     * @return string
     */
    public function toString()
    {        
        $regEx = $this->start;
        
        foreach ($this->expressions as $expression) {
            $regEx .= $expression->toString();
        }
        
        return $regEx.$this->end;
    }
    
    /**
     * This PHP magic method returns the concatenated partial regular expression as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

}
