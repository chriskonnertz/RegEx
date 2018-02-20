<?php

// Ensure backward compatibility
// @see http://stackoverflow.com/questions/42811164/class-phpunit-framework-testcase-not-found#answer-42828632
if (!class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

use \ChrisKonnertz\RegEx\RegEx;

/**
 * Class RegExTest for tests with PHPUnit.
 */
class RegExTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Creates and returns a new instance of the main class
     *
     * @return ChrisKonnertz\RegEx\RegEx
     */
    protected function getInstance()
    {
        return new RegEx();
    }

    /**
     * Enhances a partial regular expression to a complete regular expression.
     * Returns that regular expression as a string.
     *
     * @param $content
     * @return string
     */
    protected function wrapPartialRegEx($content)
    {
        return '/(?:'.$content.')/';
    }

    public function testMagicToString()
    {
        $regEx = $this->getInstance();
        $regEx->addAnd('test');

        $stringified = ''.$regEx;

        $this->assertEquals($regEx->toString(), $stringified);
    }

    public function testExample()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd('http')
            ->addOption('s')
            ->addAnd('://')
            ->addOption('www.')
            ->addWordChars()
            ->addAnd('.')
            ->addWordChars();

        $expected = '/(?:http)(?:s)?(?:\:\/\/)(?:www\.)?(?:\w*)(?:\.)(?:\w*)/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddComment()
    {
        $regEx = $this->getInstance();

        $comment = 'Hello.';
        $regEx->addComment($comment);

        $this->assertEquals('/(?#'.$comment.')/', $regEx->toString());
    }

    public function testAddRaw()
    {
        $regEx = $this->getInstance();

        $raw = '.*';
        $regEx->addRaw($raw);

        $this->assertEquals($this->wrapPartialRegEx($raw), $regEx->toString());
    }

    public function testAddAnyChar()
    {
        $regEx = $this->getInstance();

        $regEx->addAnyChar();

        $expected = $this->wrapPartialRegEx('.');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddAnyChars()
    {
        $regEx = $this->getInstance();

        $regEx->addAnyChars();

        $expected = $this->wrapPartialRegEx('.+');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testaddMaybeAnyChars()
    {
        $regEx = $this->getInstance();

        $regEx->addMaybeAnyChars();

        $expected = $this->wrapPartialRegEx('.*');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddDigit()
    {
        $regEx = $this->getInstance();

        $regEx->addDigit();

        $expected = $this->wrapPartialRegEx('\d');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddDigits()
    {
        $regEx = $this->getInstance();

        $regEx->addDigits();

        $expected = $this->wrapPartialRegEx('\d+');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddMaybeDigits()
    {
        $regEx = $this->getInstance();

        $regEx->addMaybeDigits();

        $expected = $this->wrapPartialRegEx('\d*');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddWordChar()
    {
        $regEx = $this->getInstance();

        $regEx->addWordChar();

        $expected = $this->wrapPartialRegEx('\w');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddWordChars()
    {
        $regEx = $this->getInstance();

        $regEx->addWordChars();

        $expected = $this->wrapPartialRegEx('\w+');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddMaybeWordChars()
    {
        $regEx = $this->getInstance();

        $regEx->addMaybeWordChars();

        $expected = $this->wrapPartialRegEx('\w*');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAdWhiteSpaceChar()
    {
        $regEx = $this->getInstance();

        $regEx->addWhiteSpaceChar();

        $expected = $this->wrapPartialRegEx('\s');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddWhiteSpaceChars()
    {
        $regEx = $this->getInstance();

        $regEx->addWhiteSpaceChars();

        $expected = $this->wrapPartialRegEx('\s+');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddMaybeWhiteSpaceChars()
    {
        $regEx = $this->getInstance();

        $regEx->addMaybeWhiteSpaceChars();

        $expected = $this->wrapPartialRegEx('\s*');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddTabChar()
    {
        $regEx = $this->getInstance();

        $regEx->addTabChar();

        $expected = $this->wrapPartialRegEx('\t');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddTabChars()
    {
        $regEx = $this->getInstance();

        $regEx->addTabChars();

        $expected = $this->wrapPartialRegEx('\t+');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddMaybeTabChars()
    {
        $regEx = $this->getInstance();

        $regEx->addMaybeTabChars();

        $expected = $this->wrapPartialRegEx('\t*');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddLineBeginning()
    {
        $regEx = $this->getInstance();

        $regEx->addLineBeginning();

        $expected = $this->wrapPartialRegEx('^');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddLineEnd()
    {
        $regEx = $this->getInstance();

        $regEx->addLineEnd();

        $expected = $this->wrapPartialRegEx('$');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testReplace()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd('hate');

        $expected = 'We like to like code';
        $this->assertEquals($expected, $regEx->replace('like', 'We hate to hate code'));

        $this->assertEquals($expected, $regEx->replace('like', 'We hate to hate code', PHP_INT_MAX, $count));
        $this->assertEquals(2, $count);
    }

    public function testTraverse()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd('http')
            ->addOption('s')
            ->addAnd('://')
            ->addOption('www.')
            ->addRaw('.*');

        $regEx->traverse(function($expression, int $level, bool $hasChildren)
        {
            // Do nothing, just traverse
        });
    }

    public function testGetSize()
    {
        $regEx = $this->getInstance();

        $expected = 0;
        $this->assertEquals($expected, $regEx->getSize());

        $regEx->addWordChar();

        $expected = 1;
        $this->assertEquals($expected, $regEx->getSize());

        $regEx->addWordChar();

        $expected = 2;
        $this->assertEquals($expected, $regEx->getSize());
        $this->assertEquals($expected, $regEx->getSize(true));
    }

    public function testModifiers()
    {
        $regEx = $this->getInstance();

        $expected = [];
        $this->assertEquals($expected, $regEx->getActiveModifiers());

        $regEx->setMultiLineModifier(true);
        $regEx->setSingleLineModifier(true);
        $regEx->setInsensitiveModifier(true);
        $regEx->setExtendedModifier(true);

        $expected = [
            RegEx::MULTI_LINE_MODIFIER_SHORTCUT,
            RegEx::SINGLE_LINE_MODIFIER_SHORTCUT,
            RegEx::INSENSITIVE_MODIFIER_SHORTCUT,
            RegEx::EXTENDED_MODIFIER_SHORTCUT,
        ];
        $this->assertEquals($expected, $regEx->getActiveModifiers());

        $this->assertEquals(true, $regEx->isModifierActive(RegEx::MULTI_LINE_MODIFIER_SHORTCUT));
        $regEx->setMultiLineModifier(false);
        $this->assertEquals(false, $regEx->isModifierActive(RegEx::MULTI_LINE_MODIFIER_SHORTCUT));
    }

    public function testGetExpressions()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd('http')
            ->addOption('s')
            ->addAnd('://')
            ->addOption('www.')
            ->addRaw('.*');

        $expected = 5;
        $this->assertEquals($expected, sizeof($regEx->getExpressions()));
    }

    public function testStartAndEnd()
    {
        $regEx = $this->getInstance();

        $start = $regEx->getStart().'start';
        $end = $regEx->getEnd().'end';

        $regEx->setStart($start);
        $regEx->setEnd($end);

        $this->assertEquals($start, $regEx->getStart());
        $this->assertEquals($end, $regEx->getEnd());
    }

    public function testVisualisation()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd('some ')
            ->addOr('man', 'woman');

        $expected = '<pre><strong>AndEx</strong> (Size: 1): <code style="background-color: #DDD">(?:some )</code><br>'.
            '&nbsp;&nbsp;<strong>string</strong>: <code style="background-color: #DDD">some </code><br><strong>OrEx'.
            '</strong> (Size: 2): <code style="background-color: #DDD">(?:man|woman)</code><br>&nbsp;&nbsp;<strong>'.
            'string</strong>: <code style="background-color: #DDD">man</code><br>&nbsp;&nbsp;<strong>string</strong>'.
            ': <code style="background-color: #DDD">woman</code><br></pre>';
        $this->assertEquals($expected, $regEx->getVisualisation());
        $this->assertEquals($expected, $regEx->getVisualisation(true));

        $expected = 'AndEx (Size: 1): (?:some )'.PHP_EOL.
            '  string: some '.PHP_EOL.
            'OrEx (Size: 2): (?:man|woman)'.PHP_EOL.
            '  string: man'.PHP_EOL.
            '  string: woman'.PHP_EOL;
        $this->assertEquals($expected, $regEx->getVisualisation(false));
    }

    public function testClear()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd('Some random stuff');
        $regEx->setExtendedModifier(true);
        $regEx->clear();

        $this->assertEquals(0, sizeof($regEx->getExpressions()));
        $this->assertEquals(0, sizeof($regEx->getActiveModifiers()));
    }
}