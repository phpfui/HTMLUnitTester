# PHPFUI\HTMLUnitTester [![Tests](https://github.com/phpfui/HTMLUnitTester/actions/workflows/tests.yml/badge.svg)](https://github.com/phpfui/HTMLUnitTester/actions?query=workflow%3Atests) [![Latest Packagist release](https://img.shields.io/packagist/v/phpfui/html-unit-tester.svg)](https://packagist.org/packages/phpfui/html-unit-tester) ![](https://img.shields.io/badge/PHPStan-level%206-brightgreen.svg?style=flat)

[PHPUnit](https://phpunit.de/) Testing extensions for HMTL and CSS. **PHPFUI\HTMLUnitTester** allows you to unit test HTML and CSS for errors and warnings. Often simple errors in HTML or CSS create hard to debug issues where a simple check will reveal bad code.

This package will check detect errors and warnings in HTML and CSS in stand alone strings, files, entire directories or urls.

For the best performanance, a local install of [https://github.com/validator/validator](https://github.com/validator/validator) is recommended.
## Installation
```
composer require phpfui/html-unit-tester
```
## Configuration
It is recommended you run [https://github.com/validator/validator](https://github.com/validator/validator) locally. Install [Java](https://www.java.com/ES/download/) and download the [.jar file](https://github.com/validator/validator/releases). Run with the following command:
```
java -Xss1024k -Dnu.validator.servlet.bind-address=127.0.0.1 -cp .\vnu.jar nu.validator.servlet.Main 8888
```
To run unit tests with GitHub Actions, add the following lines to you workflows test yml file:
```
- name: Setup Java
	uses: actions/setup-java@v3
	with:
		distribution: 'temurin'
		java-version: '11'

- name: Download vnu checker
	run: wget https://github.com/validator/validator/releases/download/latest/vnu.jar

- name: Run Nu Html Checker (v.Nu)
	run: java -cp vnu.jar -Xss1024k -Dnu.validator.servlet.bind-address=127.0.0.1 nu.validator.servlet.Main 8888 &
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

## License
PHPFUI\HTMLUnitTester is distributed under the MIT License.

### PHP Versions
This library only supports **modern** versions of PHP which still receive security updates. While we would love to support PHP from the late Ming Dynasty, the advantages of modern PHP versions far out weigh quaint notions of backward compatibility. Time to upgrade.

