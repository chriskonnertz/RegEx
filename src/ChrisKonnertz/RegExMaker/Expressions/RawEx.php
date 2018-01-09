<?php

namespace ChrisKonnertz\RegExMaker\Expressions;

/**
 * This expression will not quote its regular expression characters.
 * Example: ab
 */
class RawEx extends AbstractExpression
{

    /**
     * Setter for the expressions array.
     * This overwrites the implementation of the abstract base class.
     * It differs by not quoting the partial expressions.
     *
     * @param array $expressions
     */
    public function setExpressions(array $expressions)
    {
        $this->validate($expressions);

        $this->expressions = $expressions;
    }

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
