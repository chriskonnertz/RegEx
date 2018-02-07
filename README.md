# RegEx

[![Build Status](https://img.shields.io/travis/chriskonnertz/RegEx.svg)](https://travis-ci.org/chriskonnertz/RegEx)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/chriskonnertz/RegEx/master/LICENSE)

Use methods to fluently create a regular expression in PHP. 
This is more intuitive and understandable than writing plain regular expressions.


**State: Alpha**

## Installation

Through [Composer](https://getcomposer.org/):

```
composer require chriskonnertz/regex
```

From then on you may run `composer update` to get the latest version of this library.

It is possible to use this library without using Composer but then it is necessary to register an 
[autoloader function](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md#example-implementation).

> This library requires PHP 7.0 or higher.

## Usage example

Here is an example. It assumes that there is an autoloader.

```php
$regEx = new ChrisKonnertz\RegEx\RegEx();

$regEx->addAnd('http')
      ->addOption('s')
      ->addAnd('://')
      ->addOption('www.');
      
echo $regEx;
```

This will print out `/(?:http)(?:s)?(?:\:\/\/)(?:www\.)?/`. There is not much beauty in this but this is a valid
regular expression. Note that special characters will be quoted. You may call the `addRaw()` method to avoid this behaviour.

## Builder methods

> The example results might differ from the actual output. 
Some of them are simplified to make it easier to understand them.

### addAnyChar

```php
$regEx->addAnyChar();
```

Example result: `.`

### addAnyChars

```php
$regEx->addAnyChars();
```

Example result: `.*`

### addWordChar

```php
$regEx->addWordChar();
```

Example result: `\w`

### addWordChars

```php
$regEx->addWordChars();
```

Example result: `\w*`

### addWhiteSpaceChar

```php
$regEx->addWhiteSpaceChar();
```

Example result: `\s`

### addWhiteSpaceChars

```php
$regEx->addWhiteSpaceChars();
```

Example result: `\s*`

### testAddTabChar

```php
$regEx->testAddTabChar();
```

Example result: `\t`

### testAddTabChars

```php
$regEx->testAddTabChars();
```

Example result: `\t*`

### addAnd

```php
$regEx->addAnd('ht')->addAnd('tp');
```

Example result: `http`

### addOr

```php
$regEx->addOr('http', 'https');
```

Example result: `http|https`

### addOption

```php
$regEx->addAnd('http')->addAnd('s');
```

Example result: `https(?:s)?`

### addCapturingGroup

```php
$regEx->addCapturingGroup('test');
```

Example result: `(test)`

## PHPVerbalExpressions

RegEx has been inspired by [PHPVerbalExpressions](https://github.com/VerbalExpressions/PHPVerbalExpressions).
It is not better than VerbalExpressions but different. RegEx makes more use of OOP principles. 
Therefore it is more flexible but also more complex.

## General notes

* Official PHP documentation about the syntax of regular expressions: http://php.net/manual/de/reference.pcre.pattern.syntax.php

* The code of this library is formatted according to the code style defined by the 
[PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) standard.

* Status of this repository: _Maintained_. Create an [issue](https://github.com/chriskonnertz/RegEx/issues) 
and you will get a response, usually within 48 hours.
