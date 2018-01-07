<?php

namespace ChrisKonnertz\RegExMaker\Expressions;

class AndEx extends AbstractBaseEx
{

    /**
     * Array with all values (at least 1)
     *
     * @var array
     */
    protected $values;
    
    public function __construct(...$values) 
    {
        if (count($values) === 0) {
            throw new \InvalidArgumentException('You have to pass at least one argument to the constructor of an AndEx object.');
        }
        
        // Validation
        foreach ($values as $index => $value) {
            if (! (is_string($value) or is_int($value) or is_float($value) or $value instanceof BaseEx)) {
                throw new \InvalidArgumentException('Type of the '.($index + 1).'. passed value is invalid.');
            }
        }
    
        $this->values = $value;
    }
    
    /**
     * This PHP magic method returns the regular expression as a string
     *
     * @return string
     */
    public function getRegEx()
    {
        $regEx = '';
        
        foreach ($values as $value) {
            $regEx .= $value;
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
