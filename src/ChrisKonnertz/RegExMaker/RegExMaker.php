<?php

namespace ChrisKonnertz\RegExMaker;

class RegExMaker
{

    /**
     * The current version number
     */
    const VERSION = '0.0.1';
    
    protected $expressions = [];
    
    public function __construct()
    {
        // TODO remove empty constructor?
    }
    
    public function addAnd($value)
    {
        if ($value isntanceof \Closure) {
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
