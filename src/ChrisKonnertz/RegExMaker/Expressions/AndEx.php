<?php

namespace ChrisKonnertz\RegExMaker\Expressions;

/**
 * This expression requires that all of it parts exist in the tested string.
 * Example: ab
 */
class AndEx extends AbstractExpression
{

    /**
     * Returns the complete regular expressions as a string
     *
     * @return string
     */
    public function toString()
    {
        $regEx = '(?:';
        
        foreach ($this->values as $value) {
            $regEx .= $value;
        }
        
        return $regEx.')';
    }

}
