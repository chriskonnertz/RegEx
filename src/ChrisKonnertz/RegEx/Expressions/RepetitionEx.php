<?php

namespace ChrisKonnertz\RegEx\Expressions;

/**
 * This expression requires that its inner part exists n to m times in the tested string.
 *
 * Example resulting regex: (a|b)
 */
class RepetitionEx extends AbstractExpression
{

    /**
     * Const that represents "infinite" as an integer.
     * Must be an integer less than 0.
     */
    const INFINITE = -1;

    /**
     * The minimum of repetitions
     *
     * @var int
     */
    protected $min = 0;

    /**
     * The maximum of repetitions
     *
     * @var int
     */
    protected $max = 0;

    /**
     * Constructor of the abstract expression class.
     *
     * @param int $min The minimum of repetitions. Must be >= 0.
     * @param int $max The maximum of repetitions. Must be >= 0 and >= $min.
     * @param string|int|float|AbstractExpression ...$expressions The partial expressions
     */
    public function __construct(int $min, int $max, ...$expressions)
    {
        if ($min < 0) {
            throw new \InvalidArgumentException('The minimum cannot be less than 0');
        }
        if ($max != self::INFINITE) {
            if ($max < 0) {
                throw new \InvalidArgumentException('The maximum cannot be less than 0');
            }
        }
        if ($max < $min) {
            throw new \InvalidArgumentException('The maximum cannot be less than the minimum');
        }

        $this->min = $min;
        $this->max = $max;

        $this->setExpressions($expressions);
    }

    /**
     * Validates the partial expressions that are passed to the constructor of the concrete class.
     * Valid types of the array values are: string|int|float|AbstractExpression
     * Feel free to override this method if you need enhanced validation.
     *
     * @param array $expressions
     * @return void
     * @throws \Exception
     */
    public function validate(array $expressions)
    {
        if (count($expressions) < 2) {
            throw new \InvalidArgumentException(
                'You have to pass at least two arguments to the constructor of an object of type"'.gettype($this).'".'
            );
        }

        parent::validate($expressions);
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

        $repetitions = '{'.$this->min.'}'; // This means "exact $min repetitions"
        if ($this->min !== $this->max) {
            if ($this->max !== self::INFINITE) {
                $repetitions = '{'.$this->min.','.$this->max.'}';
            } else {
                switch ($this->min) {
                    case 0:
                        $repetitions = '*';
                        break;
                    case 1:
                        $repetitions = '+';
                        break;
                    default:
                        $repetitions = '{' . $this->min . ',}';
                }
            }
        }

        return $regEx.')'.$repetitions;
    }

    /**
     * Getter for the min property
     *
     * @return int
     */
    public function getMin() : int
    {
        return $this->min;
    }

    /**
     * Setter for the min property
     *
     * @param int $min
     */
    public function setMin(int $min)
    {
        $this->min = $min;
    }

    /**
     * Getter for the max property
     *
     * @return int
     */
    public function getMax() : int
    {
        return $this->max;
    }

    /**
     * Setter for the max property
     *
     * @param int $max
     */
    public function setMax(int $max)
    {
        $this->max = $max;
    }

}
