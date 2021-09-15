# PHPFUI\HTMLUnitTester [![Build Status](https://travis-ci.org/phpfui/HTMLUnitTester.png?branch=master)](https://travis-ci.org/phpfui/HTMLUnitTester) [![Latest Packagist release](https://img.shields.io/packagist/v/phpfui/html-unit-tester.svg)](https://packagist.org/packages/phpfui/html-unit-tester)

[PHPUnit](https://phpunit.de/) Testing extensions for HMTL and CSS. **PHPFUI\HTMLUnitTester** allows you to unit test HTML and CSS for errors and warnings. Often simple errors in HTML or CSS create hard to debug issues where a simple check will reveal bad code.

This package will check detect errors and warnings in HTML and CSS in stand alone strings, files, entire directories or urls.
# Requirements
- PHP 7.1 or higher
- PHPUnit 7 or higher

For the best performanance, a local install of [https://github.com/validator/validator](https://github.com/validator/validator) is recommended.
## Installation
```
composer require phpfui/html-unit-tester
```
## Configuration
It is recommended you run [https://github.com/validator/validator](https://github.com/validator/validator) locally. Install [Java](https://www.java.com/ES/download/) and download the [.jar file](https://github.com/validator/validator/releases). Run with the following command:
```
java -Xss1024k -cp vnu.jar nu.validator.servlet.Main 8888
```
If you are not using a local server, you will need to add the following lines to your phpunit.xml config in the **phpunit** element:
```xml
<php>
  <env name="PHPFUI\HTMLUnitTester\Extensions_url" value="http://validator.w3.org/nu"/>
  <env name="PHPFUI\HTMLUnitTester\Extensions_delay" value="500000"/>
</php>
```

## Usage
Extend your unit tests from \PHPFUI\HTMLUnitTester\Extensions
```php
class UnitTest extends \PHPFUI\HTMLUnitTester\Extensions
  {
  public function testValidHtml()
    {
    $this->assertValidHtml('<h1>Header</h1>');
    $this->assertValidHtmlPage('<!DOCTYPE html><html><head><meta charset="utf-8"/><title>Title</title></head><body><div>This is a test</div></body></html>');
    }
  }
```
You can use any of the following asserts:
- assertNotWarningCss
- assertNotWarningCssFile
- assertNotWarningCssUrl
- assertNotWarningFile
- assertNotWarningHtml
- assertNotWarningHtmlPage
- assertNotWarningUrl
- assertValidCss
- assertValidCssFile
- assertValidCssUrl
- assertValidFile
- assertValidHtml
- assertValidHtmlPage
- assertValidUrl

## Directory Testing
Instead of file by file testing, use **assertDirectory** to test an entire directory. Any files added to the directory will be automatically tested.
```php
	$this->assertDirectory('ValidCSS', 'cssDirectory', 'Invalid CSS');
	$this->assertDirectory('NotWarningCSS', 'cssDirectory', 'CSS has warnings');
```
The error message will include the offending file name.

## Examples
See [examples](https://github.com/phpfui/HTMLUnitTester/blob/master/tests/UnitTest.php)

## Documentation

Full documentation at [PHPFUI\HTMLUnitTester](http://phpfui.com/?p=d&n=PHPFUI%5CHTMLUnitTester)
