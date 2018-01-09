<?php

namespace ChrisKonnertz\RegExMaker\Expressions;

/**
 * Example: ab
 */
class AndEx extends AbstractExpression
{

    /**
     * Returns the complete regular expressions as a string
     *
     * @return string
     */
    public function getRegEx()
    {
        $regEx = '';
        
        foreach ($this->values as $value) {
            $regEx .= $value;
        }
        
        return $regEx;
    }

}
