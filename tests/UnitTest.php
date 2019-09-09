<?php

/**
 * This file is part of the PHPFUI package
 *
 * (c) Bruce Wells
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source
 * code
 */

use \PHPFUI\HTMLUnitTester\Extensions;

class UnitTest extends \PHPFUI\HTMLUnitTester\Extensions
	{

	public function testNotWarningCss() : void
		{
		$this->assertNotWarningCss('strong {font-weight: bolder;}');
	}

	public function testNotWarningCssFile() : void
		{
		$this->assertNotWarningCssFile('examples/valid.css');
		}

	public function testNotWarningCssUrl() : void
		{
		$this->assertNotWarningCssUrl('https://validator.w3.org/nu/style.css');
		}

  public function testNotWarningFile() : void
    {
    $this->assertNotWarningFile('examples/valid.html');
    }

  public function testNotWarningHtml() : void
    {
		$this->assertNotWarningHtml('<h1>Header</h2>');
    }

  public function testNotWarningUrl() : void
    {
    $this->assertNotWarningUrl('https://validator.w3.org/nu/');
    }

  public function testValidCss() : void
    {
    $this->assertValidCss('strong {font-weight: bolder;}');
    }

	public function testValidCssFile() : void
    {
    $this->assertValidCssFile('examples/valid.css');
		}

  public function testValidCssUrl() : void
    {
    $this->assertValidCssUrl('https://validator.w3.org/nu/style.css');
    }

  public function testValidFile() : void
    {
    $this->assertValidFile('examples/valid.html');
    }

  public function testValidHtml()
    {
    $this->assertValidHtml('<h1>Header</h1>');
    $this->assertValidHtml('<!DOCTYPE html><html><head><meta charset="utf-8"/><title>Title</title></head><body><div>This is a test</div></body></html>');
    }

  public function testValidUrl() : void
    {
    $this->assertValidUrl('https://validator.w3.org/nu/');
    }

  }