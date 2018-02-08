# RegEx

[![Build Status](https://img.shields.io/travis/chriskonnertz/RegEx.svg)](https://travis-ci.org/chriskonnertz/RegEx)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/chriskonnertz/RegEx/master/LICENSE)

Use methods to fluently create a regular expression in PHP. 
This is more intuitive and understandable than writing plain regular expressions.


**Current state: beta**

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

## Miscellaneous methods

### setModifier

```php
$regEx->setModifier(RegEx::MULTI_LINE_MODIFIER_SHORTCUT, true);
```

Activates or deactivates a modifier. 
The current state of the modifier does not matter, so for example you can 
(pseudo-)deactivate a modifier before ever activating it.

[Learn more about modifiers...](http://php.net/manual/en/reference.pcre.pattern.modifiers.php)

### setInsensitiveModifier etc.

```php
$regEx->setInsensitiveModifier();
$regEx->setInsensitiveModifier(true);
$regEx->setInsensitiveModifier(false);
```

Activates or deactivates the "insensitive" ("i") modifier.
There are setters for all modifiers.

### getActiveModifiers

```php
$modifiers = $regEx->getActiveModifiers();
```

Returns an array with the modifier shortcuts that are currently active.

### isModifierActive()

```php
$active = $regEx->isModifierActive(RegEx::MULTI_LINE_MODIFIER_SHORTCUT);
```

Decides if a modifier is active or not

### test

```php
$matches = $regEx->test('https//www.example.com/');
```

Tests a given subject (a string) against the regular expression.
Returns the matches.
Throws an exception when there occurs an error while testing.

### traverse

```php
$regEx->traverse(function($expression, int $level, bool $hasChildren)
{
    var_dump($expression, $level, $hasChildren);
});
```

Call this method if you want to traverse it and all of it child expression, 
no matter how deep they are nested in the tree. You only have to pass a closure, 
you do not have to pass an argument for the level parameter. 
The callback will have three arguments: The first is the child expression 
(an object of type AbstractExpression or a string | int | float), 
the second is the level of the that expression and the third tells you if 
it has children.

### clear

```php
$regEx->clear();
```

Removes all partial expressions.

### getSize

```php
$flatSize = $regEx->getSize();
$deepSize = $regEx->getSize(true);
```
Returns the number of partial expressions. 
If the parameter is false, only the partial expressions on the root level are counted. 
If the parameter is true, the method traverses trough all partial expressions and counts 
all partial expressions without sub expressions. Or with other words: If you visualize 
the regular expression as a tree then this method will only count its leaves.

### getExpressions

```php
$expressions = $regEx->getExpressions();
```

Getter for the partial expressions array.


### getStart

```php
$start = $regEx->getStart()
```

Getter for the "start" property

### setStart

```php
$regEx->setStart('/')
```

Setter for the "start" property. 
This is a raw string.

### getEnd

```php
$end = $regEx->getEnd()
```

Getter for the "end" property. 
This is a raw string - it is not quoted.

### setEnd

```php
$regEx->setEnd('/')
```

Setter for the "end" property

### toString

```php
$stringified = $regEx->toString();
```

Returns the concatenated partial regular expressions as a string.
The magic method `__toString` ahs been implemented as well so you may convert the RegEx object to a string.

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
