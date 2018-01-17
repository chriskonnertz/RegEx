<?php

namespace ChrisKonnertz\RegEx\Expressions;

/**
 * This expression requires that all of it parts exist in the tested string.
 *
 * Example resulting regex: (ab)
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
        
        foreach ($this->expressions as $expression) {
            $regEx .= $expression;
        }
        
        return $regEx.')';
    }

}
