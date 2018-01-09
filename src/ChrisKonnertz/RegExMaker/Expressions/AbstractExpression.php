<?php

namespace ChrisKonnertz\RegExMaker\Expressions;

abstract class AbstractExpression
{

    /**
     * Array with all values (at least 1) of the expression
     * Valid types of the array values are: string|int|float|AbstractExpression
     *
     * @var array
     */
    protected $values;

    /**
     * Constructor of the expression class.
     *
     * @param string|int|float|AbstractExpression ...$values
     */
    public function __construct(...$values)
    {
        $this->validate($values);

        $this->values = $values;
    }

    /**
     * Validates the values that are passed to the constructor of the concrete class
     * Valid types of the array values are: string|int|float|AbstractExpression
     * Feel free to override this method if you need enhanced validation.
     *
     * @param array $values
     * @return void
     * @throws \Exception
     */
    public function validate($values)
    {
        if (count($values) === 0) {
            throw new \InvalidArgumentException(
                'You have to pass at least one argument to the constructor of an object of type"'.gettype($this).'".'
            );
        }

        foreach ($values as $index => $value) {
            if (! (is_string($value) or is_int($value) or is_float($value) or $value instanceof AbstractExpression)) {
                throw new \InvalidArgumentException('Type of the '.($index + 1).'. passed value is invalid.');
            }
        }
    }

    /**
     * Returns the complete regular expressions as a string.
     * The concrete expression class has to implement this class.
     *
     * @return string
     */
    abstract public function getRegEx();

    /**
     * This PHP magic method returns the complete regular expression as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getRegEx();
    }
}
