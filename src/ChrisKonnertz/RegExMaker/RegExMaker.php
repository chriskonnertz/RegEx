<?php

namespace ChrisKonnertz\RegExMaker;

use ChrisKonnertz\RegExMaker\Expressions\AbstractExpression;
use Closure;

class RegExMaker
{

    /**
     * The current version number
     */
    const VERSION = '0.4.0';

    /**
     * The start of the regular expression
     *
     * @var string
     */
    protected $start = '/^';

    /**
     * Array with all partial expressions
     *
     * @var array
     */
    protected $expressions = [];

    /**
     * Then end of the regular expression
     *
     * @var string
     */
    protected $end = '/';
    
    /**
     * Add an item to the regular expression and wrap it in an "and" expression.
     * This expression requires that all of it parts exist in the tested string.
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
     * This expression requires that one of it parts exists in the tested string.
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
     * The parts of this expression may or may not exist in the tested string.
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
     * Add one ore more items to the regular expression and wrap them in a "raw" expression.
     * This expression will not quote its regular expression characters.
     * TODO Add examples
     *
     * @param string|int|float|Closure|AbstractExpression $values
     * @return self
     */
    public function addRaw(...$values)
    {
        foreach ($values as &$value) {
            if ($value instanceof Closure) {
                $value = $value($this);
            }
        }

        $expression = new Expressions\RawEx(...$values);
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
     * Getter for the expressions array
     *
     * @return array
     */
    public function getExpressions()
    {
        return $this->expressions;
    }
    
    /**
     * Returns the complete regular expressions as a string
     * 
     * @return string
     */
    public function getRegEx()
    {        
        $regEx = $this->start;
        
        foreach ($this->expressions as $expression) {
            $regEx .= $expression->getRegEx();
        }
        
        return $regEx.$this->end;
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
