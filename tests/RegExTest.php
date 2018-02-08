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

    public function testMagicToString()
    {
        $regEx = $this->getInstance();
        $regEx->addAnd('test');

        $stringyfied = ''.$regEx;

        $this->assertEquals($regEx->toString(), $stringyfied);
    }

    public function testExample()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd("http")
            ->addOption("s")
            ->addAnd("://")
            ->addOption("www.");

        $expected = '/(?:http)(?:s)?(?:\:\/\/)(?:www\.)?/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddRaw()
    {
        $regEx = $this->getInstance();

        $expected = '.*';
        $regEx->addRaw($expected);

        $this->assertEquals('/(?:'.$expected.')/', $regEx->toString());
    }

    public function testAddAnyChar()
    {
        $regEx = $this->getInstance();

        $regEx->addAnyChar();

        $expected = '/(?:.)/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddAnyChars()
    {
        $regEx = $this->getInstance();

        $regEx->addAnyChars();

        $expected = '/(?:.*)/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddWordChar()
    {
        $regEx = $this->getInstance();

        $regEx->addWordChar();

        $expected = '/(?:\w)/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddWordChars()
    {
        $regEx = $this->getInstance();

        $regEx->addWordChars();

        $expected = '/(?:\w*)/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAdWhiteSpaceChar()
    {
        $regEx = $this->getInstance();

        $regEx->addWhiteSpaceChar();

        $expected = '/(?:\s)/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAdWhiteSpaceChars()
    {
        $regEx = $this->getInstance();

        $regEx->addWhiteSpaceChars();

        $expected = '/(?:\s*)/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddTabChar()
    {
        $regEx = $this->getInstance();

        $regEx->addTabChar();

        $expected = '/(?:\t)/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testAddTabChars()
    {
        $regEx = $this->getInstance();

        $regEx->addTabChars();

        $expected = '/(?:\t*)/';
        $this->assertEquals($expected, $regEx->toString());
    }

    public function testTraverse()
    {
        $regEx = $this->getInstance();

        $regEx->addAnd("http")
            ->addOption("s")
            ->addAnd("://")
            ->addOption("www.")
            ->addRaw('.*');

        $regEx->traverse(function($expression, int $level, bool $hasChildren)
        {
            // Do nothing, just traverse
        });
    }

    public function getSize()
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

        $regEx->addAnd("http")
            ->addOption("s")
            ->addAnd("://")
            ->addOption("www.")
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
}