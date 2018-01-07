<?php

namespace ChrisKonnertz\RegExMaker;

use Closure;

class RegExMaker
{

    /**
     * The current version number
     */
    const VERSION = '0.0.1';
    
    /**
     * Array with all partial expressions
     *
     * @var array
     */
    protected $expressions = [];
    
    /**
     * Add something to the regular expression and wrap it in an and expression.
     * TODO Add examples
     *
     * @param string|int|float|Closure $value
     * @return void
     */
    public function addAnd($value)
    {
        if ($value instanceof Closure) {
            $value = $value($this);
            
            // TODO validate $value
        }
        
        $andEx = new Expressions\AndEx($value);
        $this->expressions[] = $andEx;
    }
    
    /**
     * Returns the complete regular expressions as a string
     * 
     * @return string
     */
    public function getRegEx()
    {        
        $regEx = '';
        
        foreach ($this->expression as $expression) {
            $regEx .= $expression->getRegEx();
        }
        
        return $regEx;
    }
    
    /**
     * This PHP magic method returns the regular expression as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getRegEx();
    }       

}
