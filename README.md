# RegExMaker

[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/chriskonnertz/RegExMaker/master/LICENSE)

Use methods to fluently create a regular expression in PHP. 
This is more intuitive and understandable than writing plain regular expressions.

## Installation

Through [Composer](https://getcomposer.org/):

```
composer require chriskonnertz/regexmaker
```

From then on you may run `composer update` to get the latest version of this library.

It is possible to use this library without using Composer but then it is necessary to register an 
[autoloader function](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md#example-implementation).

> This library requires PHP 7.0 or higher.

## Usage example

Here is a minimalistic example. It assumes that there is an autoloader.

```php
$regExMaker = new ChrisKonnertz\RegExMaker\RegExMaker();

$regExMaker->addAnd("http")
      ->addOption("s")
      ->addAnd("://")
      ->addOption("www.");
      
echo $regExMaker;
```

## PHPVerbalExpressions

RegExMaker has been inspired by [PHPVerbalExpressions](https://github.com/VerbalExpressions/PHPVerbalExpressions).
It is not better than VerbalExpressions but different. RegExMaker makes more use of OOP principles. 
Therefore its more flexible but also more complex.

## General notes

* The code of this library is formatted according to the code style defined by the 
[PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) standard.

* Status of this repository: _Maintained_. Create an [issue](https://github.com/chriskonnertz/RegExMaker/issues) 
and you will get a response, usually within 48 hours.