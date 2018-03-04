# RegEx

[![Build Status](https://img.shields.io/travis/chriskonnertz/RegEx.svg)](https://travis-ci.org/chriskonnertz/RegEx)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/chriskonnertz/RegEx/master/LICENSE)

Use methods to fluently create a regular expression in PHP. 
This is more intuitive and understandable than writing plain regular expressions.


**Current state: beta**

**To do**: Add negation, add [] support 

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
      ->addOption('www.')
      ->addWordChars()
      ->addAnd('.')
      ->addWordChars();
      
echo $regEx;
```

This will print out `/(?:http)(?:s)?(?:\:\/\/)(?:www\.)?(?:\w+)(?:\.)(?:\w+)/` and  
match for example `https://www.example.org`. 
There is not much beauty in this regular expression. However, it is valid.

Note that special characters will be quoted: `123-456` will become `123\-456`. 
You may call the `addRaw()` method to avoid this behaviour.

## Builder methods

> The example results might differ from the actual output. 
Some of them are simplified to make it easier to understand them.

### addAnyChar

```php
$regEx->addAnyChar();
```

Adds a partial expression that expects any single character (except by default "new line").

Example result: `.`

### addAnyChars

```php
$regEx->addAnyChars();
```

Adds a partial expression that expects 0..n of any characters (except by default "new line").

Example result: `.*`

### addAnyChars

```php
$regEx->addAnyChars();
```

Adds a partial expression that expects 1..n of any characters (except by default "new line").

Example result: `.+`

### addMaybeAnyChars

```php
$regEx->addMaybeAnyChars();
```

Adds a partial expression that expects 0..n of any characters (except by default "new line").

Example result: `.*`

### addDigit

```php
$regEx->addDigit();
```

Adds a partial expression that expects a single digit.
Same as: [0-9]

Example result: `\d`

### addDigits

```php
$regEx->addDigits();
```

Adds a partial expression that expects 1..n of digits.
Same as: [0-9]+

Example result: `\d+`

### addMaybeDigits

```php
$regEx->addMaybeDigits();
```

Adds a partial expression that expects 0..n of digits.
Same as: [0-9]*

Example result: `\d*`

### addNonDigit

```php
$regEx->addNonDigit();
```

Adds a partial expression that expects a character that is not a digit.
Same as: [^0-9]

Example result: `\D`

### addNonDigits

```php
$regEx->addNonDigits();
```

Adds a partial expression that expects 1..n of characters that are not digits.
Same as: [^0-9]+

Example result: `\D+`

### addMaybeNonDigits

```php
$regEx->addMaybeNonDigits();
```

Adds a partial expression that expects 0..n of characters that are not digits.
Same as: [^0-9]*

Example result: `\D*`

### addWordChar

```php
$regEx->addWordChar();
```

Adds a partial expression that expects a single word character.
This includes letters, digits and the underscore.
Same as: [a-zA-Z_0-9]

Example result: `\w`

### addWordChars

```php
$regEx->addWordChars();
```

Adds a partial expression that expects 1..n of word characters.
This includes letters, digits and the underscore.
Same as: [a-zA-Z_0-9]+

Example result: `\w+`

### addMaybeWordChars

```php
$regEx->addMaybeWordChars();
```

Adds a partial expression that expects 0..n of word characters.
This includes letters, digits and the underscore.
Same as: [a-zA-Z_0-9]*

Example result: `\w*`

### addNonWordChar

```php
$regEx->addNonWordChar();
```

Adds a partial expression that expects a character that is not a word character.
This includes letters, digits and the underscore.
Same as: [^a-zA-Z_0-9]

Example result: `\W`

### addNonWordChars

```php
$regEx->addNonWordChars();
```

Adds a partial expression that expects 1..n of characters that are not word characters.
This includes letters, digits and the underscore.
Same as: [^a-zA-Z_0-9]+

Example result: `\W+`

### addMaybeNonWordChars

```php
$regEx->addMaybeNonWordChars();
```

Adds a partial expression that expects 0..n of characters that are not word characters.
This includes letters, digits and the underscore.
Same as: [^a-zA-Z_0-9]*

Example result: `\W*`

### addWhiteSpaceChar

```php
$regEx->addWhiteSpaceChar();
```

Adds a partial expression that expects a white space character.
This includes: space, \f, \n, \r, \t and \v

Example result: `\s`

### addWhiteSpaceChars

```php
$regEx->addWhiteSpaceChars();
```

Adds a partial expression that expects 1..n of white space characters.
This includes: space, \f, \n, \r, \t and \v

Example result: `\s+`

### addMaybeWhiteSpaceChars

```php
$regEx->addMaybeWhiteSpaceChars();
```

Adds a partial expression that expects 0..n of white space characters.
This includes: space, \f, \n, \r, \t and \v

Example result: `\s*`

### addTabChar

```php
$regEx->addTabChar();
```

Adds a partial expression that expects a single tabulator (tab).

Example result: `\t`

### addTabChars

```php
$regEx->addTabChars();
```

Adds a partial expression that expects 1..n tabulators (tabs).

Example result: `\t+`

### addMaybeTabChars

```php
$regEx->addMaybeTabChars();
```

Adds a partial expression that expects 0..n tabulators (tabs).

Example result: `\t*`

### addLineBreak

```php
$regEx->addLineBreak();
$regEx->addLineBreak(PHP_EOL);
```

Adds a partial expression that expects a line break.
Per default `\n` and `\r\n` will be recognized.
You may pass a parameter to define a specific line break pattern.

Example result: `\r?\n`

### addLineBreaks

```php
$regEx->addLineBreaks();
$regEx->addLineBreaks(PHP_EOL);
```

Adds a partial expression that expects a 1..n line breaks.
Per default \n and \r\n will be recognized.
You may pass a parameter to define a specific line break pattern.

Example resulting regex: (\r?\n)+

### addMaybeLineBreaks

```php
$regEx->addMaybeLineBreaks();
$regEx->addMaybeLineBreaks(PHP_EOL);
```

Adds a partial expression that expects a 0..n line breaks.
Per default \n and \r\n will be recognized.
You may pass a parameter to define a specific line break pattern.

Example resulting regex: (\r?\n)*

### addLineBeginning

```php
$regEx->addLineBeginning();
```

Adds a partial expression that expects the beginning of a line.
Line breaks mark the beginning of a line.

Example result: `^`

### addLineEnd

```php
$regEx->addLineEnd();
```

Adds a partial expression that expects the end of a line.
 Line breaks mark the end of a line.

Example result: `$`

### addAnd

```php
$regEx->addAnd('ht')->addAnd('tp');
```

Add a partial expression to the overall regular expression and wrap it in an "and" expression.
This expression requires that all of its parts exist in the tested string.

Example result: `http`

> The `RegEx` class has a constructor that is an alias of the `addAnd` method: 
`new RegEx('ab')` will generate the same regular expression as `regEx->andAdd('ab')`.

### addOr

```php
$regEx->addOr('http', 'https');
```

Add at least two partial expressions to the overall regular expression and wrap it in an "or" expression.
This expression requires that one of its parts exists in the tested string.

Example result: `http|https`

### addOption

```php
$regEx->addAnd('http')->addAnd('s');
```

Add one ore more partial expressions to the overall regular expression and wrap them in an "optional" expression.
The parts of this expression may or may not exist in the tested string.

Example result: `https(s)?`

### addCapturingGroup

```php
$regEx->addCapturingGroup('test');
```

Add one ore more partial expressions to the overall regular expression and wrap them in a "capturing group" expression.
This expression will be added to the matches when the overall regular expression is tested.
If you add more than one part these parts are linked by "and".

Example result: `(test)`

### addComment

```php
$regEx->addComment('This is a comment');
```

Add one ore more comments to the overall regular expression and wrap them in a "comment" expression.
This expression will not quote its regular expression characters.
ATTENTION: Comments are not allowed to include any closing brackets ( ")" )! Quoting them will not work.

Example result: `(?#This is a comment)`

> Consider to use a PHP comment instead.

## Miscellaneous methods

### quote

```php
$quoted = $regEx->quote('Hello.')
```

Quotes (escapes) regular expression characters and returns the result. 
Example: "Hello." => "Hello\\."

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
Throws an exception if an error occurs while testing.

### replace

```php
$modified = $regEx->replace('like', 'We hate to hate code');
```

Performs search and replace with the regular expression.
Returns the modified string.
Throws an exception if an error occurs while replacing.

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
the second is the level of that expression and the third tells you if 
it has children.

### clear

```php
$regEx->clear();
```

Resets the regular expression.

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

### getVisualisation

```php
$visualisation = $regEx->getStructure(true);
echo $visualisation;
```

Returns a "visualisation" of the structure of the regular expression. 
This might be helpful if you try to understand how the regular expression is built. 
If the parameter is set to true, the result may include HTML tags. 

Example result:
```
AndEx (Size: 1): (?:line)
  string: line
RawEx (Size: 1): (?:\r?\n*)
  string: \r?\n*
AndEx (Size: 1): (?:break)
  string: break
```

### toString

```php
$stringified = $regEx->toString();
```

Returns the concatenated partial regular expressions as a string.
The magic method `__toString` has been implemented as well so you may convert the RegEx object to a string.

## PHPVerbalExpressions

RegEx has been inspired by [PHPVerbalExpressions](https://github.com/VerbalExpressions/PHPVerbalExpressions).
It is not better than VerbalExpressions but different. RegEx makes more use of OOP principles. 
Therefore it is better suited to mimic the structure of a regular expression but it is also more complex.

## General notes

* Contributions welcome. Do not hesitate to create issues and pull requests.

* Why the extensive use of (not capturing) groups? Well, to me it is not very intuitive that "ab*" is the same as
"(?:ab)*". Always using (non capturing) groups emphasizes the structure of a regular expression.

* Official PHP documentation about the syntax of regular expressions: http://php.net/manual/de/reference.pcre.pattern.syntax.php

* The code of this library is formatted according to the code style defined by the 
[PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) standard.

* Status of this repository: _Maintained_. Create an [issue](https://github.com/chriskonnertz/RegEx/issues) 
and you will get a response, usually within 48 hours.
