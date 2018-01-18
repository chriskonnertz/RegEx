<?php

// Ensure backward compatibility
// @see http://stackoverflow.com/questions/42811164/class-phpunit-framework-testcase-not-found#answer-42828632
if (!class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

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
        return new ChrisKonnertz\RegEx\RegEx();
    }

    public function testMagicToString()
    {
        $regEx = $this->getInstance();

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

        $expected = '/^(?:http)(?:s)?(?:\:\/\/)(?:www\.)?/';
        $this->assertEquals($expected, $regEx);
    }

    public function testAddRaw()
    {
        $regEx = $this->getInstance();

        $raw = '.*';
        $regEx->addRaw($raw);

        $this->assertEquals($raw, $regEx);
    }

    public function testAddAnyChar()
    {
        $regEx = $this->getInstance();

        $regEx->addAnyChar();

        $expected = '(?:.)';
        $this->assertEquals($expected, $regEx);
    }

    public function testAddAnyChars()
    {
        $regEx = $this->getInstance();

        $regEx->addAnyChars();

        $expected = '(?:.*)';
        $this->assertEquals($expected, $regEx);
    }

    public function testAddWordChar()
    {
        $regEx = $this->getInstance();

        $regEx->addWordChar();

        $expected = '(?:\w)';
        $this->assertEquals($expected, $regEx);
    }

    public function testAdWhiteSpaceChar()
    {
        $regEx = $this->getInstance();

        $regEx->addWhiteSpaceChar();

        $expected = '(?:\s)';
        $this->assertEquals($expected, $regEx);
    }

    public function testAddTabChar()
    {
        $regEx = $this->getInstance();

        $regEx->addTabChar();

        $expected = '(?:\w)';
        $this->assertEquals($expected, $regEx);
    }

    // TODO create missing method tests
}