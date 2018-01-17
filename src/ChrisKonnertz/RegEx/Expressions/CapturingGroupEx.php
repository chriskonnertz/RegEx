<?php

namespace ChrisKonnertz\RegEx\Expressions;

/**
 * This expression will be added to the matches when the overall regular expression is tested.
 * This expression requires that all of it parts exist in the tested string.
 * If you add more than one part these parts are linked by "and".
 *
 * Example resulting regex: (ab)
 */
class CapturingGroupEx extends AbstractExpression
{

    /**
     * Returns the complete regular expressions as a string
     *
     * @return string
     */
    public function toString()
    {
        $regEx = '(';
        
        foreach ($this->expressions as $expression) {
            $regEx .= $expression;
        }
        
        return $regEx.')';
    }

}
