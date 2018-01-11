<?php

namespace ChrisKonnertz\RegEx\Expressions;

/**
 * The parts of this expression may or may not exist in the tested string.
 * If you add more than one part these parts are linked by "and".
 * Example: (a)?
 */
class OptionEx extends AbstractExpression
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
        
        return $regEx.')?';
    }

}
