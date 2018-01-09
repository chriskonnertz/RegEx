<?php

namespace ChrisKonnertz\RegExMaker\Expressions;

/**
 * Example: (a|b)
 */
class OrEx extends AbstractExpression
{

    /**
     * Validates the values that are passed to the constructor of the concrete class
     * Valid types of the array values are: string|int|float|AbstractExpression
     *
     * @param array $values
     * @return void
     * @throws \Exception
     */
    public function validate($values)
    {
        if (count($values) < 2) {
            throw new \InvalidArgumentException(
                'You have to pass at least two arguments to the constructor of an object of type"'.gettype($this).'".'
            );
        }

        parent::validate($values);
    }
    
    /**
     * Returns the complete regular expressions as a string
     *
     * @return string
     */
    public function getRegEx()
    {
        $regEx = '';
        
        foreach ($this->values as $value) {
            if ($regEx === '') {
                $regEx = '(';
            } else {
                $regEx .= '|';
            }
            $regEx .= $value;
        }

        return $regEx.')';
    }

}
