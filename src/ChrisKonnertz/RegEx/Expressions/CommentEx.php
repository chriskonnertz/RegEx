<?php

namespace ChrisKonnertz\RegEx\Expressions;

/**
 * This expression will add a comment.
 *
 * Example resulting regex: (?#This is a comment)
 */
class CommentEx extends AbstractExpression
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
        $regEx = '(?#';

        foreach ($this->expressions as $expression) {
            $regEx .= $expression;
        }

        return $regEx.')';
    }

}
