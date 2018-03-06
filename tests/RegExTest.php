<?php

use ChrisKonnertz\RegEx\RegEx;

/**
 * Class RegExTest for tests with PHPUnit.
 */
class RegExTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Creates and returns a new instance of the main class
     *
     * @param mixed[] ...$params
     * @return RegEx
     */
    protected function getInstance(...$params) : RegEx
    {
        return new RegEx(...$params);
    }

    /**
     * Enhances a partial regular expression to a complete regular expression.
     * Returns that regular expression as a string.
     *
     * @param mixed $content     Content of the partial expression
     * @param bool  $wrapInGroup Optional: Wrap it in a non-capturing group?
     * @return string
     */
    protected function wrapPartialRegEx($content, bool $wrapInGroup = true) : string
    {
        if ($wrapInGroup) {
            $content = '(?:'.$content.')';
        }
        return '/'.$content.'/';
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

        $expected = '/(?:http)(?:s)?(?:\:\/\/)(?:www\.)?(?:\w+)(?:\.)(?:\w+)/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddRaw()
    {
        $regEx = $this->getInstance();

        $raw = '.*';
        $regEx->addRaw($raw);

        $this->assertEquals($this->wrapPartialRegEx($raw), $regEx->toString());
    }

    public function testAddRange()
    {
        $regEx = $this->getInstance();

        $rangeOne = 'a-z';
        $rangeTwo = '123';
        $regEx->addRange($rangeOne, $rangeTwo);

        $this->assertEquals($this->wrapPartialRegEx('['.$rangeOne.$rangeTwo.']', false), $regEx->toString());
    }

    public function testAddInvertedRange()
    {
        $regEx = $this->getInstance();

        $rangeOne = 'a-z';
        $rangeTwo = '123';
        $regEx->addInvertedRange($rangeOne, $rangeTwo);

        $this->assertEquals($this->wrapPartialRegEx('[^'.$rangeOne.$rangeTwo.']', false), $regEx->toString());
    }

    public function testAddComment()
    {
        $regEx = $this->getInstance();

        $comment = 'Hello.';
        $regEx->addComment($comment);

        $this->assertEquals('/(?#'.$comment.')/', $regEx->toString());
    }

    public function testAddAnd()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd('ht', 'tp');

        $this->assertEquals($this->wrapPartialRegEx('http'), $regEx->toString());
    }

    public function testAddOr()
    {
        $regEx = $this->getInstance();

        $regEx->addOr('http', 'https');

        $this->assertEquals($this->wrapPartialRegEx('http|https'), $regEx->toString());
    }

    public function testAddOption()
    {
        $regEx = $this->getInstance();

        $regEx->addOption('s');

        $this->assertEquals($this->wrapPartialRegEx('(?:s)?', false), $regEx->toString());
    }

    public function testAddRepetition()
    {
        $regEx = $this->getInstance();

        $regEx->addRepetition(0, 1, 'ab');
        $this->assertEquals($this->wrapPartialRegEx('(?:ab)?', false), $regEx->toString());
        $regEx->clear();

        $regEx->addRepetition(1, 1, 'ab');
        $this->assertEquals($this->wrapPartialRegEx('ab'), $regEx->toString());
        $regEx->clear();

        $regEx->addRepetition(1, 2, 'ab');
        $this->assertEquals($this->wrapPartialRegEx('ab{1,2}'), $regEx->toString());
        $regEx->clear();

        $regEx->addRepetition(0, \ChrisKonnertz\RegEx\Expressions\RepetitionEx::INFINITE, 'ab');
        $this->assertEquals($this->wrapPartialRegEx('ab*'), $regEx->toString());
        $regEx->clear();

        $regEx->addRepetition(1, \ChrisKonnertz\RegEx\Expressions\RepetitionEx::INFINITE, 'ab');
        $this->assertEquals($this->wrapPartialRegEx('ab+'), $regEx->toString());
        $regEx->clear();

        $regEx->addRepetition(1, \ChrisKonnertz\RegEx\Expressions\RepetitionEx::INFINITE, 'ab');
        $this->assertEquals($this->wrapPartialRegEx('ab{2,}'), $regEx->toString());
        $regEx->clear();
    }

    public function testAddCapturingGroup()
    {
        $regEx = $this->getInstance();

        $regEx->addCapturingGroup('test');

        $this->assertEquals($this->wrapPartialRegEx('(test)', false), $regEx->toString());
    }

    public function testConstructor()
    {
        $regEx = $this->getInstance('a', 'b');

        $this->assertEquals($this->wrapPartialRegEx('ab'), $regEx->toString());
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

    public function testAddMaybeAnyChars()
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

    public function testAddLetter()
    {
        $regEx = $this->getInstance();

        $regEx->addLetter();

        $expected = $this->wrapPartialRegEx('[a-zA-Z]', false);
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddLetters()
    {
        $regEx = $this->getInstance();

        $regEx->addLetters();

        $expected = $this->wrapPartialRegEx('[a-zA-Z]+');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddMaybeLetters()
    {
        $regEx = $this->getInstance();

        $regEx->addMaybeLetters();

        $expected = $this->wrapPartialRegEx('[a-zA-Z]*');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddNonDigit()
    {
        $regEx = $this->getInstance();

        $regEx->addNonDigit();

        $expected = $this->wrapPartialRegEx('\D');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddNonDigits()
    {
        $regEx = $this->getInstance();

        $regEx->addNonDigits();

        $expected = $this->wrapPartialRegEx('\D+');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddMaybeNonDigits()
    {
        $regEx = $this->getInstance();

        $regEx->addMaybeNonDigits();

        $expected = $this->wrapPartialRegEx('\D*');
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

    public function testAddNonWordChar()
    {
        $regEx = $this->getInstance();

        $regEx->addNonWordChar();

        $expected = $this->wrapPartialRegEx('\W');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddNonWordChars()
    {
        $regEx = $this->getInstance();

        $regEx->addNonWordChars();

        $expected = $this->wrapPartialRegEx('\W+');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddNonMaybeWordChars()
    {
        $regEx = $this->getInstance();

        $regEx->addMaybeNonWordChars();

        $expected = $this->wrapPartialRegEx('\W*');
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddWhiteSpaceChar()
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

    public function testAddLineBreak()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd('line')->addLineBreak()->addAnd('break');
        $matches = $regEx->test("line\nbreak");
        $this->assertEquals(1, sizeof($matches));
        $matches = $regEx->test("line\r\nbreak");
        $this->assertEquals(1, sizeof($matches));

        $regEx->addAnd('line')->addLineBreak("\r\n")->addAnd('break');
        $matches = $regEx->test("line\nbreak");
        $this->assertEquals(0, sizeof($matches));
    }

    public function testAddLineBreaks()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd('line')->addLineBreaks()->addAnd('break');
        $matches = $regEx->test("line\n\nbreak");
        $this->assertEquals(1, sizeof($matches));

        $regEx->clear()->addAnd('line')->addLineBreaks()->addAnd('break');
        $matches = $regEx->test("linebreak");
        $this->assertEquals(0, sizeof($matches));
    }

    public function testAddMaybeLineBreaks()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd('line')->addMaybeLineBreaks()->addAnd('break');
        $matches = $regEx->test("line\n\nbreak");
        $this->assertEquals(1, sizeof($matches));

        $regEx->clear()->addAnd('line')->addMaybeLineBreaks()->addAnd('break');
        $matches = $regEx->test("linebreak");
        $this->assertEquals(1, sizeof($matches));
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

        $expected = '<pre class="regex-vis"><strong class="regex-vis-type">AndEx</strong> (Size: 1): '.
            '<code class="regex-vis-value" style="background-color: #DDD">(?:some )</code><br>&nbsp;&nbsp;'.
            '<strong class="regex-vis-type">string</strong>: <code class="regex-vis-value" '.
            'style="background-color: #DDD">some </code><br><strong class="regex-vis-type">OrEx</strong> (Size: 2): '.
            '<code class="regex-vis-value" style="background-color: #DDD">(?:man|woman)</code><br>&nbsp;&nbsp;'.
            '<strong class="regex-vis-type">string</strong>: <code class="regex-vis-value" '.
            'style="background-color: #DDD">man</code><br>&nbsp;&nbsp;<strong class="regex-vis-type">string</strong>: '.
            '<code class="regex-vis-value" style="background-color: #DDD">woman</code><br></pre>';
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
