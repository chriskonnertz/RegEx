<?php

// Ensure backward compatibility
// @see http://stackoverflow.com/questions/42811164/class-phpunit-framework-testcase-not-found#answer-42828632
if (!class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

/**
 * Class RegExMakerTest for tests with PHPUnit.
 */
class RegExMakerTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Creates and returns a new instance
     *
     * @return ChrisKonnertz\RegExMaker\RegExMaker(
     */
    protected function getInstance()
    {
        return new ChrisKonnertz\RegExMaker\RegExMaker();
    }

    // TODO create tests
}