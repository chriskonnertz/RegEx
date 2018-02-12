<?php

namespace ChrisKonnertz\RegEx\Expressions;

/**
 * This expression requires that one of it parts exists in the tested string.
 *
 * ExaExample resulting regexmple: (a|b)
 */
class OrEx extends AbstractExpression
{

    /**
     * Validates the partial expressions that are passed to the constructor of the concrete class.
     * Valid types of the array values are: string|int|float|bool|AbstractExpression
     * Feel free to override this method if you need enhanced validation.
     *
     * @param array $expressions
     * @return void
     * @throws \Exception
     */
    public function validate(array $expressions)
    {
        if (count($expressions) < 2) {
            throw new \InvalidArgumentException(
                'You have to pass at least two arguments to the constructor of an object of type"'.gettype($this).'".'
            );
        }

        parent::validate($expressions);
    }
    
    /**
     * Returns the complete regular expressions as a string
     *
     * @return string
     */
    public function toString()
    {
        $regEx = '';
        
        foreach ($this->expressions as $expression) {
            if ($regEx === '') {
                $regEx = '(?:';
            } else {
                $regEx .= '|';
            }
            $regEx .= $expression;
        }

        return $regEx.')';
    }

}
