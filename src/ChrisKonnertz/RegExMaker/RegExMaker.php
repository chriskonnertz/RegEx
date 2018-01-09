<?php

namespace ChrisKonnertz\RegExMaker;

use ChrisKonnertz\RegExMaker\Expressions\AbstractExpression;
use Closure;

class RegExMaker
{

    /**
     * The current version number
     */
    const VERSION = '0.3.0';
    
    /**
     * Array with all partial expressions
     *
     * @var array
     */
    protected $expressions = [];
    
    /**
     * Add an item to the regular expression and wrap it in an "and" expression.
     * TODO Add examples
     *
     * @param string|int|float|Closure|AbstractExpression $values
     * @return self
     */
    public function addAnd(...$values)
    {
        foreach ($values as &$value) {
            if ($value instanceof Closure) {
                $value = $value($this);
            }
        }

        $expression = new Expressions\AndEx(...$values);
        $this->expressions[] = $expression;

        return $this;
    }

    /**
     * Add at least two items to the regular expression and wrap it in an "or" expression.
     * TODO Add examples
     *
     * @param string|int|float|Closure|AbstractExpression $values
     * @return self
     */
    public function addOr(...$values)
    {
        foreach ($values as &$value) {
            if ($value instanceof Closure) {
                $value = $value($this);
            }
        }

        $expression = new Expressions\OrEx(...$values);
        $this->expressions[] = $expression;

        return $this;
    }

    /**
     * Add one ore more items to the regular expression and wrap them in an "optional" expression.
     * TODO Add examples
     *
     * @param string|int|float|Closure|AbstractExpression $values
     * @return self
     */
    public function addOption(...$values)
    {
        foreach ($values as &$value) {
            if ($value instanceof Closure) {
                $value = $value($this);
            }
        }

        $expression = new Expressions\OptionEx(...$values);
        $this->expressions[] = $expression;

        return $this;
    }

    /**
     * Removes all expressions.
     *
     * @return $this
     */
    public function clear()
    {
        $this->expressions = [];

        return $this;
    }
    
    /**
     * Returns the complete regular expressions as a string
     * 
     * @return string
     */
    public function getRegEx()
    {        
        $regEx = '';
        
        foreach ($this->expressions as $expression) {
            $regEx .= $expression->getRegEx();
        }
        
        return $regEx;
    }
    
    /**
     * This PHP magic method returns the complete regular expression as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getRegEx();
    }

}
