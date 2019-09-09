<?php

/**
 * This file is part of the PHPFUI/HTMLUnitTester package
 *
 * (c) Bruce Wells
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source
 * code
 */

namespace PHPFUI\HTMLUnitTester;

class Extensions extends \PHPUnit\Framework\TestCase implements \PHPUnit\Runner\Hook
	{

	private static $throttle;
	private static $validator;

	public static function setUpBeforeClass() : void
		{
		$url = $_ENV[__CLASS__ . '_url'] ?? 'http://127.0.0.1:8888';
		$throttleMicroSeconds = $_ENV[__CLASS__ . '_delay'] ?? 0;
		if (! filter_var($url, FILTER_VALIDATE_URL))
			{
			throw new \PHPUnit\Framework\Exception($url . ' is not a valid URL');
			}

		self::$throttle = new Throttle($throttleMicroSeconds);
		self::$validator = new \HtmlValidator\Validator($url);
		}

	public function assertNotWarningCss(string $css, string $message = '') : void
		{
		$response = $this->validateCss($css);
		self::assertThat($response, new WarningConstraint(), $message);
		}

	public function assertNotWarningCssFile(string $file, string $message = '') : void
		{
		$response = $this->validateCss($this->getFromFile($file));
		self::assertThat($response, new WarningConstraint(), $message);
		}

	public function assertNotWarningCssUrl(string $url, string $message = '') : void
		{
		$response = $this->validateCss($this->getFromUrl($url));
		self::assertThat($response, new WarningConstraint(), $message);
		}

	public function assertNotWarningFile(string $file, string $message = '') : void
		{
		$response = $this->validateHtml($this->getFromFile($file));
		self::assertThat($response, new WarningConstraint(), $message);
		}

	public function assertNotWarningHtml(string $html, string $message = '') : void
		{
		$response = $this->validateHtml($html);
		self::assertThat($response, new WarningConstraint(), $message);
		}

	public function assertNotWarningUrl(string $url, string $message = '') : void
		{
		$response = $this->validateHtml($this->getFromUrl($url));
		self::assertThat($response, new ErrorConstraint(), $message);
		}

	public function assertValidCss(string $css, string $message = '') : void
		{
		$response = $this->validateCss($css);
		self::assertThat($response, new ErrorConstraint(), $message);
		}

	public function assertValidCssFile(string $file, string $message = '') : void
		{
		$response = $this->validateCss($this->getFromFile($file));
		self::assertThat($response, new ErrorConstraint(), $message);
		}

	public function assertValidCssUrl(string $url, string $message = '') : void
		{
		$response = $this->validateCss($this->getFromUrl($url));
		self::assertThat($response, new ErrorConstraint(), $message);
		}

	public function assertValidFile(string $file, string $message = '') : void
		{
		$response = $this->validateHtml($this->getFromFile($file));
		self::assertThat($response, new ErrorConstraint(), $message);
		}

	public function assertValidHtml(string $html, string $message = '') : void
		{
		$response = $this->validateHtml($html);
		self::assertThat($response, new ErrorConstraint(), $message);
		}

	public function assertValidUrl(string $url, string $message = '') : void
		{
		$response = $this->validateHtml($this->getFromUrl($url));
		self::assertThat($response, new ErrorConstraint(), $message);
		}

	private function getFromFile(string $file) : string
		{
		if (! file_exists($file))
			{
			throw new \PHPUnit\Framework\Exception("File {$file} was not found.\n");
			}

		if (! is_readable($file))
			{
			throw new \PHPUnit\Framework\Exception("File {$file} is not readable.\n");
			}
		$html = file_get_contents($file);

		return $html;
		}

	private function getFromUrl(string $url) : string
		{
		// Check that $url is a valid url
		if (false === filter_var($url, FILTER_VALIDATE_URL))
			{
			throw new \PHPUnit\Framework\Exception("Url {$url} is not valid.\n");
			}

		$context  = stream_context_create(['http' => ['user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:69.0) Gecko/20100101 Firefox/69.0']]);
		$html = file_get_contents($url, false, $context);

		// Check that something was returned
		if (! strlen($html))
			{
			throw new \PHPUnit\Framework\Exception("{$url} is empty.\n");
			}

		return $html;
		}

	private function validateCss(string $css) : \HtmlValidator\Response
		{
		if (false === stripos($css, 'html>'))
			{
			$css = '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>Title</title><style>' . $css . '</style></head><body><hr></body></html>';
			}
		self::$throttle->delay();
		$response = self::$validator->validateDocument($css);

		return $response;
		}

	private function validateHtml(string $html) : \HtmlValidator\Response
		{
		if (false === stripos($html, 'html>'))
			{
			$html = '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>Title</title></head><body>' . $html . '</body></html>';
			}
		self::$throttle->delay();
		$response = self::$validator->validateDocument($html);

		return $response;
		}

	}