<?php

namespace ChrisKonnertz\RegEx;

use ChrisKonnertz\RegEx\Expressions\AbstractExpression;
use Closure;

/**
 * This is the RegEx base class. It is the API frontend of the RegEx library.
 * Call its add<Something>() methods to add partial expressions.
 * Finally call its toString() method to retrieve the complete regular expression as a string.
 */
class RegEx
{

    /**
     * The delimiter indicates the start and the end of a regular expression
     */
    const DELIMITER = '/';

    /**
     * Shortcut of the "insensitive" ("i") modifier.
     * If active, letters in the pattern match both upper and lower case letters.
     */
    const INSENSITIVE_MODIFIER_SHORTCUT = 'i';

    /**
     * Shortcut of the "multi line" ("m") modifier.
     * If active, treats the string being matched against as multiple lines.
     */
    const MULTI_LINE_MODIFIER_SHORTCUT = 'm';

    /**
     * Shortcut of the "single line" ("s") modifier.
     * If active, a dot metacharacter in the pattern matches all characters, including newlines.
     */
    const SINGLE_LINE_MODIFIER_SHORTCUT = 's';

    /**
     * Shortcut of the "extended" ("x") modifier.
     * If active, whitespace is permitted.
     * */
    const EXTENDED_MODIFIER_SHORTCUT = 'x';

    /**
     * Array with all available modifier shortcuts
     *
     * @see http://php.net/manual/en/reference.pcre.pattern.modifiers.php
     */
    const MODIFIER_SHORTCUTS = [
        self::INSENSITIVE_MODIFIER_SHORTCUT,
        self::MULTI_LINE_MODIFIER_SHORTCUT,
        self::SINGLE_LINE_MODIFIER_SHORTCUT,
        self::EXTENDED_MODIFIER_SHORTCUT
    ];

    /**
     * The current version number
     */
    const VERSION = '0.9.4';

    /**
     * The start of the regular expression (=prefix)
     *
     * @var string
     */
    protected $start = self::DELIMITER;

    /**
     * Array with all partial expressions
     *
     * @var AbstractExpression[]
     */
    protected $expressions = [];

    /**
     * The end of the regular expression (=suffix)
     *
     * @var string
     */
    protected $end = self::DELIMITER;

    /**
     * Array with the active modifier shortcuts.
     * Valid values are one of the values in this array: self::MODIFIER_SHORTCUTS
     *
     * @var string[]
     */
    protected $modifiers = [];

    /**
     * Quotes (escapes) regular expression characters and returns the result.
     * Example: "Hello." => "Hello\."
     *
     * @see http://php.net/manual/en/function.preg-quote.php
     *
     * @param int|float|bool|string $expression
     * @return string
     */
    public function quote($expression)
    {
        return preg_quote($expression, RegEx::DELIMITER);
    }

    /**
     * Adds a partial expression that expects any single character (except by default "new line").
     *
     * Example resulting regex: .
     *
     * @return self
     */
    public function addAnyChar()
    {
        return $this->addRaw('.');
    }

    /**
     * Adds a partial expression that expects 1..m of any characters (except by default "new line").
     *
     * Example resulting regex: .+
     *
     * @return self
     */
    public function addAnyChars()
    {
        return $this->addRaw('.+');
    }

    /**
     * Adds a partial expression that expects 0..m of any characters (except by default "new line").
     *
     * Example resulting regex: .*
     *
     * @return self
     */
    public function addAnyOrNoneChars()
    {
        return $this->addRaw('.*');
    }

    /**
     * Adds a partial expression that expects a single digit.
     * Same as: [0-9]
     *
     * Example resulting regex: \d
     *
     * @return self
     */
    public function addDigit()
    {
        return $this->addRaw('\d');
    }

    /**
     * Adds a partial expression that expects 0..m of digits.
     * Same as: [0-9]*
     *
     * Example resulting regex: \d*
     *
     * @return self
     */
    public function addDigits()
    {
        return $this->addRaw('\d*');
    }

    /**
     * Adds a partial expression that expects a single word character.
     * This includes letters, digits and the underscore.
     * Same as: [a-zA-Z_0-9]
     *
     * Example resulting regex: \w
     *
     * @return self
     */
    public function addWordChar()
    {
        return $this->addRaw('\w');
    }

    /**
     * Adds a partial expression that expects 0..m of word characters.
     * This includes letters, digits and the underscore.
     * Same as: [a-zA-Z_0-9]*
     *
     * Example resulting regex: \w*
     *
     * @return self
     */
    public function addWordChars()
    {
        return $this->addRaw('\w*');
    }

    /**
     * Adds a partial expression that expects a white space character.
     * This includes: space, \f, \n, \r, \t and \v
     *
     * Example resulting regex: \s
     *
     * @return self
     */
    public function addWhiteSpaceChar()
    {
        return $this->addRaw('\s');
    }

    /**
     * Adds a partial expression that expects 0..m of white space characters.
     * This includes: space, \f, \n, \r, \t and \v
     *
     * Example resulting regex: \s*
     *
     * @return self
     */
    public function addWhiteSpaceChars()
    {
        return $this->addRaw('\s*');
    }

    /**
     * Adds a partial expression that expects a single tabulator (tab).
     *
     * Example resulting regex: \t
     *
     * @return self
     */
    public function addTabChar()
    {
        return $this->addRaw('\t');
    }

    /**
     * Adds a partial expression that expects 0..m tabulators (tabs).
     *
     * Example resulting regex: \t*
     *
     * @return self
     */
    public function addTabChars()
    {
        return $this->addRaw('\t*');
    }

    /**
     * Adds a partial expression that expects the beginning of a line.
     * Line breaks mark the beginning of a line.
     *
     * Example resulting regex: ^
     *
     * @return self
     */
    public function addLineBeginning()
    {
        return $this->addRaw('^');
    }

    /**
     * Adds a partial expression that expects the end of a line.
     * Line breaks mark the end of a line.
     *
     * Example resulting regex: $
     *
     * @return self
     */
    public function addLineEnd()
    {
        return $this->addRaw('$');
    }

    /**
     * Add a partial expression to the overall regular expression and wrap it in an "and" expression.
     * This expression requires that all of its parts exist in the tested string.
     *
     * Example resulting regex: http
     *
     * @param string|int|float|bool|Closure|AbstractExpression $partialExpressions
     * @return self
     */
    public function addAnd(...$partialExpressions)
    {
        foreach ($partialExpressions as &$partialExpression) {
            if ($partialExpression instanceof Closure) {
                $partialExpression = $partialExpression($this);
            }
        }

        $wrapperExpression = new Expressions\AndEx(...$partialExpressions);
        $this->expressions[] = $wrapperExpression;

        return $this;
    }

    /**
     * Add at least two partial expressions to the overall regular expression and wrap it in an "or" expression.
     * This expression requires that one of its parts exists in the tested string.
     *
     * Example resulting regex: (http|https)
     *
     * @param string|int|float|bool|Closure|AbstractExpression $partialExpressions
     * @return self
     */
    public function addOr(...$partialExpressions)
    {
        foreach ($partialExpressions as &$partialExpression) {
            if ($partialExpression instanceof Closure) {
                $partialExpression = $partialExpression($this);
            }
        }

        $wrapperExpression = new Expressions\OrEx(...$partialExpressions);
        $this->expressions[] = $wrapperExpression;

        return $this;
    }

    /**
     * Add one ore more partial expressions to the overall regular expression and wrap them in an "optional" expression.
     * The parts of this expression may or may not exist in the tested string.
     *
     * Example resulting regex: https(s)?
     *
     * @param string|int|float|bool|Closure|AbstractExpression $partialExpressions
     * @return self
     */
    public function addOption(...$partialExpressions)
    {
        foreach ($partialExpressions as &$partialExpression) {
            if ($partialExpression instanceof Closure) {
                $partialExpression = $partialExpression($this);
            }
        }

        $wrapperExpression = new Expressions\OptionEx(...$partialExpressions);
        $this->expressions[] = $wrapperExpression;

        return $this;
    }

    /**
     * Add one ore more partial expressions to the overall regular expression and wrap them in a "capturing group" expression.
     * This expression will be added to the matches when the overall regular expression is tested.
     * If you add more than one part these parts are linked by "and".
     *
     * Example resulting regex: (test)
     *
     * @param string|int|float|bool|Closure|AbstractExpression $partialExpressions
     * @return self
     */
    public function addCapturingGroup(...$partialExpressions)
    {
        foreach ($partialExpressions as &$partialExpression) {
            if ($partialExpression instanceof Closure) {
                $partialExpression = $partialExpression($this);
            }
        }

        $wrapperExpression = new Expressions\CapturingGroupEx(...$partialExpressions);
        $this->expressions[] = $wrapperExpression;

        return $this;
    }

    /**
     * Add one ore more comments to the overall regular expression and wrap them in a "comment" expression.
     * This expression will not quote its regular expression characters.
     * ATTENTION: Comments are not allowed to include any closing brackets ( ")" )! Quoting them will not work.
     *
     * Example resulting regex: (?#This is a comment)
     *
     * @param string|int|float|bool $comments
     * @return self
     */
    public function addComment(...$comments)
    {
        foreach ($comments as $key => $comment) {
            if (! is_scalar($comment)) {
                throw new \InvalidArgumentException(
                    'Expected the '.($key + 1).'. comment to be scalar (int / float / string / boolean) but it is: '.
                    gettype($comment)
                );
            }

            $pos = mb_strpos($comment, ')');
            if ($pos !== false) {
                throw new \InvalidArgumentException(
                    'Comments are not allowed to include a closing bracket but there is one in the '.($key + 1)
                    .'. comment at position '.$pos
                );
            }
        }

        $wrapperExpression = new Expressions\CommentEx(...$comments);
        $this->expressions[] = $wrapperExpression;

        return $this;
    }

    /**
     * Add one ore more partial expressions to the overall regular expression and wrap them in a "raw" expression.
     * This expression will not quote its regular expression characters.
     *
     * Example resulting regex: a-b
     *
     * @param string|int|float|bool|Closure|AbstractExpression $partialExpressions
     * @return self
     */
    public function addRaw(...$partialExpressions)
    {
        foreach ($partialExpressions as &$partialExpression) {
            if ($partialExpression instanceof Closure) {
                $partialExpression = $partialExpression($this);
            }
        }

        $wrapperExpression = new Expressions\RawEx(...$partialExpressions);
        $this->expressions[] = $wrapperExpression;

        return $this;
    }

    /**
     * Activates or deactivates the "insensitive" ("i") modifier.
     * If active, letters in the pattern match both upper and lower case letters.
     *
     * @param bool $active
     * @return void
     */
    public function setInsensitiveModifier(bool $active = true)
    {
        $this->setModifier(self::INSENSITIVE_MODIFIER_SHORTCUT, $active);
    }

    /**
     * Activates or deactivates the "multi line" ("m") modifier.
     * If active, treats the string being matched against as multiple lines.
     *
     * @param bool $active
     * @return void
     */
    public function setMultiLineModifier(bool $active = true)
    {
        $this->setModifier(self::MULTI_LINE_MODIFIER_SHORTCUT, $active);
    }

    /**
     * Activates or deactivates the "single line" ("s") modifier.
     * If active, a dot meta-character in the pattern matches all characters, including newlines.
     *
     * @param bool $active
     * @return void
     */
    public function setSingleLineModifier(bool $active = true)
    {
        $this->setModifier(self::SINGLE_LINE_MODIFIER_SHORTCUT, $active);
    }
    /**
     * Activates or deactivates the "extended" ("x") modifier.
     * If active, whitespace is permitted.
     *
     * @param bool $active
     * @return void
     */
    public function setExtendedModifier(bool $active = true)
    {
        $this->setModifier(self::EXTENDED_MODIFIER_SHORTCUT, $active);
    }

    /**
     * Activates or deactivates a modifier.
     * The current state of the modifier does not matter, so for example you can
     * (pseudo-)deactivate a modifier before ever activating it.
     *
     * @see http://php.net/manual/en/reference.pcre.pattern.modifiers.php
     *
     * @param string $modifierShortcut The modifier shortcut, a single character -> self::MODIFIER_SHORTCUTS
     * @param bool   $active           Activate (true) or deactivate (false) the modifier
     * @return void
     */
    public function setModifier(string $modifierShortcut, bool $active = true)
    {
        if (! in_array($modifierShortcut, self::MODIFIER_SHORTCUTS)) {
            throw new \InvalidArgumentException(
                'Invalid modifier shortcut given, use one of these: '.implode(self::MODIFIER_SHORTCUTS, ', '));
        }

        $index = array_search($modifierShortcut, $this->modifiers);
        if ($index === false) {
            if ($active) {
                $this->modifiers[] = $modifierShortcut;
            }
        } else {
            if (! $active) {
                unset($this->modifiers[$index]);
            }
        }
    }

    /**
     * Returns an array with the modifier shortcuts that are currently active
     *
     * @return string[]
     */
    public function getActiveModifiers() : array
    {
        return $this->modifiers;
    }

    /**
     * Decides if a modifier is active or not
     *
     * @param string $modifierShortcut The modifier shortcut, a single character -> self::MODIFIER_SHORTCUTS
     * @return bool
     */
    public function isModifierActive(string $modifierShortcut) : bool
    {
        $activeModifiers = $this->getActiveModifiers();

        return in_array($modifierShortcut, $activeModifiers);
    }

    /**
     * Tests a given subject (a string) against the regular expression.
     * Returns the matches.
     * Throws an exception if an error occurs while testing.
     *
     * @see preg_match()
     *
     * @param string $subject The subject to test
     * @return array
     * @throws \Exception
     */
    public function test(string $subject) : array
    {
        $regEx = $this->toString();

        $matches = [];

        $result = preg_match($regEx, $subject, $matches);

        if ($result === false) {
            throw new \Exception('Error when executing PHP\'s preg_match() function');
        }

        return $matches;
    }

    /**
     * Performs search and replace with the regular expression.
     * Returns the modified string.
     * Throws an exception if an error occurs while replacing.
     *
     * @see preg_replace()
     *
     * @param string|string[] $replacement The string or an array with strings to replace.
     * @param string|string[] $source      The string or an array with strings to search and replace.
     * @param int             $limit       The maximum possible replacements for each pattern. -1 = no limit
     * @param int             $count       If specified, this param will be filled with the number of replacements done.
     * @return string|\string[]
     * @throws \Exception
     */
    public function replace(string $replacement, string $source, $limit = -1, &$count = -1)
    {
        $regEx = $this->toString();

        $result = preg_replace($regEx, $replacement, $source, $limit, $count);

        if ($result === null) {
            throw new \Exception('Error when executing PHP\'s preg_replace() function');
        }

        return $result;
    }

    /**
     * Call this method if you want to traverse it and all of it child expression,
     * no matter how deep they are nested in the tree. You only have to pass a closure,
     * you do not have to pass an argument for the level parameter.
     * The callback will have three arguments: The first is the child expression
     * (an object of type AbstractExpression or a string | int | float | bool),
     * the second is the level of the that expression and the third tells you if
     * it has children.
     *
     * Example:
     *
     * $regEx->traverse(function($expression, int $level, bool $hasChildren)
     * {
     *     var_dump($expression, $level, $hasChildren);
     * });
     *
     * You may also look at the self::getSize() method as another example.
     *
     * @param Closure $callback The callback closure
     * @return void
     */
    public function traverse(Closure $callback)
    {
        foreach ($this->expressions as $expression) {
            $expression->traverse($callback);
        }
    }

    /**
     * Returns a "visualisation" of the structure of the regular expression.
     * This might be helpful if you try to understand how the regular expression is built.
     * If the parameter is set to true, the result may include HTML tags.
     *
     * @param bool $html If true, use HTML tags to prettify the visualisation
     * @return string
     */
    public function getVisualisation(bool $html = true)
    {
        $output = '';

        $this->traverse(function($expression, int $level, bool $hasChildren) use (&$output, $html)
        {
            $lineBreak = $html ? '<br>' : PHP_EOL;
            $space = $html ? '&nbsp;' : ' ';

            $type = '';
            $info = '';
            $value = '';
            if ($expression instanceof Closure) {
                $type = gettype($expression);
            } elseif (is_object($expression)) {
                if (! $expression instanceof AbstractExpression) {
                    throw new \LogicException('Expected AbstractExpression but got something else');
                }

                $type = $expression->getTypeName();
                $info = ' (Size: '.$expression->getSize().'): ';
                $value = $expression->toString();
            } else {
                $type = gettype($expression);
                $info = ': ';
                $value = $expression;
            }

            if ($html) {
                $type = '<strong>'.$type.'</strong>';
                if ($value !== '') {
                    $value = '<code style="background-color: #DDD">' . htmlspecialchars($value) . '</code>';
                }
            }

            $output .= str_repeat($space, $level * 2).$type.$info.$value.$lineBreak;
        });

        if ($html) {
            $output = '<pre>'.$output.'</pre>';
        }

        return $output;
    }

    /**
     * Returns the number of partial expressions.
     * If $recursive is false, only the partial expressions on the root level are counted.
     * If $recursive is true, the method traverses trough all partial expressions and counts
     * all partial expressions without sub expressions. Or with other words: If you visualize
     * the regular expression as a tree then this method will only count its leaves.
     *
     * @param bool $recursive If true, also count nested expressions
     * @return int
     */
    public function getSize($recursive = true) : int
    {
        if ($recursive) {
            $size = 0;

            $this->traverse(function($expression, int $level, bool $hasChildren) use (&$size)
            {
                if (! $hasChildren) {
                    $size++;
                }
            });

            return $size;
        } else {
            return sizeof($this->expressions);
        }
    }

    /**
     * Getter for the partial expressions array
     *
     * @return AbstractExpression[]
     */
    public function getExpressions() : array
    {
        return $this->expressions;
    }

    /**
     * Resets the regular expression.
     *
     * @return self
     */
    public function clear()
    {
        $this->expressions = [];
        $this->modifiers = [];
        $this->start = self::DELIMITER;
        $this->end = self::DELIMITER;

        return $this;
    }

    /**
     * Getter for the "start" property
     *
     * @return string
     */
    public function getStart() : string
    {
        return $this->start;
    }

    /**
     * Setter for the "start" property.
     * This is a raw string.
     *
     * @param string $start
     */
    public function setStart(string $start)
    {
        $this->start = $start;
    }

    /**
     * Getter for the "end" property.
     * This is a raw string - it is not quoted.
     *
     * @return string
     */
    public function getEnd() : string
    {
        return $this->end;
    }

    /**
     * Setter for the "end" property
     *
     * @param string $end
     */
    public function setEnd(string $end)
    {
        $this->end = $end;
    }
    
    /**
     * Returns the concatenated partial regular expressions as a string
     * 
     * @return string
     */
    public function toString() : string
    {        
        $regEx = $this->start;
        
        foreach ($this->expressions as $expression) {
            $regEx .= $expression->toString();
        }

        $modifiers = implode('', $this->modifiers);
        
        return $regEx.$this->end.$modifiers;
    }
    
    /**
     * This PHP magic method returns the concatenated partial regular expression as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

}
