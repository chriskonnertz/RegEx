<?php

namespace ChrisKonnertz\RegExMaker\Expressions;

/**
 * This expression will not quote its regular expression characters.
 * Example: ab
 */
class RawEx extends AbstractExpression
{

    /**
     * Setter for the values array
     *
     * @param array $values
     */
    public function setValues($values)
    {
        $this->validate($values);

        $this->values = $values;
    }

    /**
     * Returns the complete regular expressions as a string
     *
     * @return string
     */
    public function getRegEx()
    {
        $regEx = '(?:';

        foreach ($this->values as $value) {
            $regEx .= $value;
        }

        return $regEx.')';
    }

}
