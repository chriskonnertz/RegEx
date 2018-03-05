<?php

namespace ChrisKonnertz\RegEx\Expressions;

/**
 * This expression will not quote its regular expression characters.
 *
 * Example resulting regex: [a-z123]
 */
class RangeEx extends AbstractExpression
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
        $regEx = '[';

        foreach ($this->expressions as $expression) {
            $regEx .= $expression;
        }

        return $regEx.']';
    }

    /**
     * Modifies the range so it excludes it inner parts from the total regular expression.
     *
     * @return void
     */
    public function makeInverted()
    {
        // Add the circumflex as the first partial expression
        if (sizeof($this->expressions) === 0) {
            $this->expressions[] = '^';
            return;
        }

        // Get the key of the first partial expression
        $keys = array_keys($this->expressions);
        $key = reset($keys);

        // If the expression is already inverted, do nothing
        if (substr($this->expressions[$key], 0, 1) === '^') {
            return;
        }

        // Prefix the first partial expression with the circumflex
        $this->expressions[$key] = '^'.$this->expressions[$key];
    }

}
