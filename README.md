# RegEx

[![Build Status](https://img.shields.io/travis/chriskonnertz/RegEx.svg)](https://travis-ci.org/chriskonnertz/RegEx)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/chriskonnertz/RegEx/master/LICENSE)

Use methods to fluently create a regular expression in PHP. 
This is more intuitive and understandable than writing plain regular expressions.

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

## More examples

Here is an example how to create a nested regular expression:

```
$regEx = new ChrisKonnertz\RegEx\RegEx();

$regEx->addRaw(new RangeEx('a-zA-Z'), '+');

echo $regEx;
```

This will print out `[a-zA-Z]+` (with some extras).

Re-using the `RegEx` object works this way:

```
$regEx = new ChrisKonnertz\RegEx\RegEx();

$regEx->addAnd('First test);
echo $regEx;

$rexEx->clear()->addAnd('Second test');
echo $regEx;
```

The `clear()` method will reset the `RegEx` object so you can reuse it to build a new regular expression.

## Builder methods

> The example results might differ from the actual output. 
Some of them are simplified to make it easier to understand them.

### addAnyChar

```php
$regEx->addAnyChar();
```

Adds a partial expression that expects any single character (except by default "new line").

Example of the resulting regex string: `.`

Examples of matching strings: `a`, `1`

### addAnyChars

```php
$regEx->addAnyChars();
```

Adds a partial expression that expects 1..n of any characters (except by default "new line").

Example of the resulting regex string: `.+`

Examples of matching strings: `a`, `a1`

### addMaybeAnyChars

```php
$regEx->addMaybeAnyChars();
```

Adds a partial expression that expects 0..n of any characters (except by default "new line").

Example of the resulting regex string: `.*`

Examples of matching strings: `a`, `a1`, empty string

### addDigit

```php
$regEx->addDigit();
```

Adds a partial expression that expects a single digit.
Same as: `[0-9]`

Example of the resulting regex string: `\d`

Examples of matching strings: `1`, `0`

### addDigits

```php
$regEx->addDigits();
```

Adds a partial expression that expects 1..n of digits.
Same as: `[0-9]+`

Example of the resulting regex string: `\d+`

Examples of matching strings: `1`, `12`

### addMaybeDigits

```php
$regEx->addMaybeDigits();
```

Adds a partial expression that expects 0..n of digits.
Same as: `[0-9]*`

Example of the resulting regex string: `\d*`

Examples of matching strings: `1`, `12`, empty string

### addNonDigit

```php
$regEx->addNonDigit();
```

Adds a partial expression that expects a character that is not a digit.
Same as: `[^0-9]`

Example of the resulting regex string: `\D`

Examples of matching strings: `a`, `-`

### addNonDigits

```php
$regEx->addNonDigits();
```

Adds a partial expression that expects 1..n of characters that are not digits.
Same as: `[^0-9]+`

Example of the resulting regex string: `\D+`

Examples of matching strings: `a`, `ab`

### addMaybeNonDigits

```php
$regEx->addMaybeNonDigits();
```

Adds a partial expression that expects 0..n of characters that are not digits.
Same as: `[^0-9]*`

Example of the resulting regex string: `\D*`

Examples of matching strings: `a`, `ab`, empty string

### addLetter

```php
$regEx->addLetter();
```

Adds a partial expression that expects a single letter.

Example of the resulting regex string: `[a-zA-Z]`

Examples of matching strings: `a`, `Z`

### addLetters

```php
$regEx->addLetters();
```

Adds a partial expression that expects 1..n of letters.

Example of the resulting regex string: `[a-zA-Z]+`

Examples of matching strings: `a`, `aB`

### addMaybeLetters

```php
$regEx->addMaybeLetters();
```

Adds a partial expression that expects 0..n of letters.

Example of the resulting regex string: `[a-zA-Z]*`

Examples of matching strings: `a`, `aB`, empty string

### addWordChar

```php
$regEx->addWordChar();
```

Adds a partial expression that expects a single word character.
This includes letters, digits and the underscore.
Same as: `[a-zA-Z_0-9]`

Example of the resulting regex string: `\w`

Examples of matching strings: `a`, `B`, `1`

### addWordChars

```php
$regEx->addWordChars();
```

Adds a partial expression that expects 1..n of word characters.
This includes letters, digits and the underscore.
Same as: `[a-zA-Z_0-9]+`

Example of the resulting regex string: `\w+`

Examples of matching strings: `a`, `ab`

### addMaybeWordChars

```php
$regEx->addMaybeWordChars();
```

Adds a partial expression that expects 0..n of word characters.
This includes letters, digits and the underscore.
Same as: `[a-zA-Z_0-9]*`

Example of the resulting regex string: `\w*`

Examples of matching strings: `a`, `ab`, empty string

### addNonWordChar

```php
$regEx->addNonWordChar();
```

Adds a partial expression that expects a character that is not a word character.
This includes letters, digits and the underscore.
Same as: `[^a-zA-Z_0-9]`

Example of the resulting regex string: `\W`

Example of matching string: `-`

### addNonWordChars

```php
$regEx->addNonWordChars();
```

Adds a partial expression that expects 1..n of characters that are not word characters.
This includes letters, digits and the underscore.
Same as: `[^a-zA-Z_0-9]+`

Example of the resulting regex string: `\W+`

Examples of matching strings: `-`, `-=`

### addMaybeNonWordChars

```php
$regEx->addMaybeNonWordChars();
```

Adds a partial expression that expects 0..n of characters that are not word characters.
This includes letters, digits and the underscore.
Same as: `[^a-zA-Z_0-9]*`

Example of the resulting regex string: `\W*`

Examples of matching strings: `-`, `-=`, empty string

### addWhiteSpaceChar

```php
$regEx->addWhiteSpaceChar();
```

Adds a partial expression that expects a white space character.
This includes: space, \f, \n, \r, \t and \v

Example of the resulting regex string: `\s`

Example of matching string: ` ` (one space)

### addWhiteSpaceChars

```php
$regEx->addWhiteSpaceChars();
```

Adds a partial expression that expects 1..n of white space characters.
This includes: space, \f, \n, \r, \t and \v

Example of the resulting regex string: `\s+`

Examples of matching strings: ` ` (one space), `  ` (two spaces)

### addMaybeWhiteSpaceChars

```php
$regEx->addMaybeWhiteSpaceChars();
```

Adds a partial expression that expects 0..n of white space characters.
This includes: space, \f, \n, \r, \t and \v

Example of the resulting regex string: `\s*`

Examples of matching strings: ` ` (one space), `  ` (two spaces), empty string

### addTabChar

```php
$regEx->addTabChar();
```

Adds a partial expression that expects a single tabulator (tab).

Example of the resulting regex string: `\t`

Examples of matching strings: `\t`

### addTabChars

```php
$regEx->addTabChars();
```

Adds a partial expression that expects 1..n tabulators (tabs).

Example of the resulting regex string: `\t+`

Examples of matching strings: `\t`, `\t\t`

### addMaybeTabChars

```php
$regEx->addMaybeTabChars();
```

Adds a partial expression that expects 0..n tabulators (tabs).

Example of the resulting regex string: `\t*`

Examples of matching strings: `\t`, `\t\t`, empty string

### addLineBreak

```php
$regEx->addLineBreak();
$regEx->addLineBreak(PHP_EOL);
```

Adds a partial expression that expects a line break.
Per default `\n` and `\r\n` will be recognized.
You may pass a parameter to define a specific line break pattern.

Example of the resulting regex string: `\r?\n`

Examples of matching strings: `\n`, `\r\n`

### addLineBreaks

```php
$regEx->addLineBreaks();
$regEx->addLineBreaks(PHP_EOL);
```

Adds a partial expression that expects a 1..n line breaks.
Per default `\n` and `\r\n` will be recognized.
You may pass a parameter to define a specific line break pattern.

Example resulting regex: `(\r?\n)+`

Examples of matching strings: `\n`, `\n\n`

### addMaybeLineBreaks

```php
$regEx->addMaybeLineBreaks();
$regEx->addMaybeLineBreaks(PHP_EOL);
```

Adds a partial expression that expects a 0..n line breaks.
Per default `\n` and `\r\n` will be recognized.
You may pass a parameter to define a specific line break pattern.

Example resulting regex: `(\r?\n)*`

Examples of matching strings: `\n`, `\n\n`, empty string

### addLineBeginning

```php
$regEx->addLineBeginning();
```

Adds a partial expression that expects the beginning of a line.
Line breaks mark the beginning of a line.

Example of the resulting regex string: `^`

### addLineEnd

```php
$regEx->addLineEnd();
```

Adds a partial expression that expects the end of a line. 
Line breaks mark the end of a line.

Example of the resulting regex string: `$`

### addRange

```php
$regEx->addRange('a-z', '123', '\-');
```

Adds one ore more ranges to the overall regular expression and wraps them in a "range" expression.
Available from-to-ranges: `a-z`, `A-Z`, `0-9`
_ATTENTION_: This expression will not automatically quote its inner parts.

Example of the resulting regex string: `[a-z123\-]`

Examples of matching strings: `a`, `1`, `-`

> This method uses the `RangeEx` expression class.

### addInvertedRange

```php
$regEx->addInvertedRange('a-z', '123', '\-');
```

Adds one ore more ranges to the overall regular expression and wraps them in an inverted "range" expression.
Available from-to-ranges: `a-z`, `A-Z`, `0-9`
_ATTENTION_: This expression will not automatically quote its inner parts.

Example of the resulting regex string: `[^a-z123\-]`

Examples of matching strings: `A`, `4`, `=`

> This method uses the `RangeEx` expression class.

### addAnd

```php
$regEx->addAnd('ht')->addAnd('tp');
```

Adds one ore more partial expression to the overall regular expression and wraps them in an "and" expression.
This expression requires that all of its parts exist in the tested string.

Example of the resulting regex string: `http`

Example of matching string: `http`

> The `RegEx` class has a constructor that is an alias of the `addAnd` method: 
`new RegEx('ab')` will generate the same regular expression as `regEx->andAdd('ab')`.

> This method uses the `AndEx` expression class.

### addOr

```php
$regEx->addOr('http', 'https');
```

Adds at least two partial expressions to the overall regular expression and wraps them in an "or" expression.
This expression requires that one of its parts exists in the tested string.

Example of the resulting regex string: `http|https`

Examples of matching strings: `http`, `https`

> This method uses the `OrEx` expression class.

### addOption

```php
$regEx->addAnd('http')->addAnd('s');
```

Adds one ore more partial expressions to the overall regular expression and wraps them in an "optional" expression.
The parts of this expression may or may not exist in the tested string.

Example of the resulting regex string: `https(s)?`

Examples of matching strings: `http`, `https`


> This method uses the `OptionEx` expression class.

### addRepetition

```php
$regEx->addRepetition(0, 1, "ab"); // Produces "ab?" and matches "ab" and empty string
$regEx->addRepetition(1, 1, "ab"); // Produces "ab" and matches "ab"
$regEx->addRepetition(1, 2, "ab"); // Produces "ab{1,2}" and matches "ab" and "abab".
$regEx->addRepetition(0, RepetitionEx::INFINITE, "ab"); // Produces "ab*" and matches 0..n "ab"
$regEx->addRepetition(1, RepetitionEx::INFINITE, "ab"); // Produces "ab+" and matches 1..n "ab"
$regEx->addRepetition(2, RepetitionEx::INFINITE, "ab"); // Produces "ab{2,}" and matches 2..n "ab"
```

Adds one ore more partial expressions to the total regular expression and wraps them in a "repetition" expression.
Expects the minimum and the maximum of repetitions as the first two arguments.
The parts of this expression have to appear `$min` to `$max` times in the tested string.

> This method uses the `RepetitionEx` expression class.

### addCapturingGroup

```php
$regEx->addCapturingGroup('test');
```

Adds one ore more partial expressions to the overall regular expression and wraps them in a "capturing group" expression.
This expression will be added to the matches when the overall regular expression is tested.
If you add more than one part these parts are linked by "and".

Example of the resulting regex string: `(test)`

> This method uses the `CapturingGroupEx` expression class.

### addComment

```php
$regEx->addComment('This is a comment');
```

Add one ore more comments to the overall regular expression and wrap them in a "comment" expression.
This expression will not automatically quote its its inner parts.
_ATTENTION_: Comments are not allowed to include any closing brackets ( ")" )! Quoting them will not work.

Example of the resulting regex string: `(?#This is a comment)`

> Consider to use PHP comments in favor of regular expression comments.

> This method uses the `CommentEx` expression class.

## Miscellaneous methods

### quote

```php
$quoted = $regEx->quote('Hello.')
```

Quotes (escapes) regular expression characters and returns the result. 
Example: `Hello.` => `Hello\.`

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
all partial expressions without sub expressions. Or with other words: If you imagine 
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
$visualisation = $regEx->getStructure(false);
echo $visualisation;
```

Returns a "visualisation" of the structure of the regular expression. 
This might be helpful if you want to understand how the regular expression is built. 
If the parameter is set to true, the result may include HTML tags. 

Example output:
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
The magic method `__toString` has been implemented as well so you may convert the `RegEx` object to a string.

## PHPVerbalExpressions

RegEx has been inspired by [PHPVerbalExpressions](https://github.com/VerbalExpressions/PHPVerbalExpressions).
It is not better than VerbalExpressions but different. RegEx makes more use of OOP principles. 
Therefore it is better suited to mimic the structure of a regular expression. 
On the downside it is a little bit more complex.

## General notes

* Contributions welcome. Do not hesitate to create issues and pull requests. Let me know if you miss a method.

* If you want to test your regular expression, you may try an [online regex tester](http://www.phpliveregex.com/).

* Why the extensive use of (not capturing) groups? Well, to me it is not very intuitive that "ab*" is the same as
"(?:ab)*". Always using (non capturing) groups emphasizes the structure of a regular expression.

* Official PHP documentation about the syntax of regular expressions: http://php.net/manual/de/reference.pcre.pattern.syntax.php

* The code of this library is formatted according to the code style defined by the 
[PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) standard.

* Status of this repository: _Maintained_. Create an [issue](https://github.com/chriskonnertz/RegEx/issues) 
and you will get a response, usually within 48 hours.
