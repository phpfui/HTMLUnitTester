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

class Extensions extends \PHPUnit\Framework\TestCase
  {

  private $throttle;
  private $validator;

  public function __construct(string $url, int $throttleMicroSeconds = 0)
    {
    if (! filter_var($url, FILTER_VALIDATE_URL))
      {
      throw new \PHPUnit\Framework\Exception($url . ' is not a valid URL');
      }

    $throttle = new Throttle($throttleMicroSeconds);
    $this->validator = new \HtmlValidator\Validator($url);
    }

  public function assertNotValidCss(string $css, string $message = '') : void
    {
    $response = $this->validateCss($css);
    }

  public function assertNotValidCssFile(string $file, string $message = '') : void
    {
    $response = $this->validateCss($this->getFromFile($file));
    }

  public function assertNotValidCssUrl(string $url, string $message = '') : void
    {
    $response = $this->validateCss($this->getFromUrl($url));
    }

  public function assertNotValidFile(string $file, string $message = '') : void
    {
    $response = $this->validateHtml($this->getFromFile($file));
    }

  public function assertNotValidHtml(string $html, string $message = '') : void
    {
    $response = $this->validateHtml($html);
    }

  public function assertNotValidUrl(string $url, string $message = '') : void
    {
    $response = $this->validateHtml($this->getFromUrl($url));
    }

  public function assertValidCss(string $css, string $message = '') : void
    {
    $response = $this->validateCss($css);
    }

  public function assertValidCssFile(string $file, string $message = '') : void
    {
    $response = $this->validateCss($this->getFromFile($file));
    }

  public function assertValidCssUrl(string $url, string $message = '') : void
    {
    $response = $this->validateCss($this->getFromUrl($url));
    }

  public function assertValidFile(string $file, string $message = '') : void
    {
    $response = $this->validateHtml($this->getFromFile($file));
    }

  public function assertValidHtml(string $html, string $message = '') : void
    {
    $response = $this->validateHtml($html);

    self::assertThat($response, new HtmlConstraint(), $message);
    }

  public function assertValidUrl(string $url, string $message = '') : void
    {
    $response = $this->validateHtml($this->getFromUrl($url));
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
    // Check that $url is a valid url.
    if (false === filter_var($url, FILTER_VALIDATE_URL))
      {
      throw new \PHPUnit\Framework\Exception("Url {$url} is not valid.\n");
      }
    $html = file_get_contents($url);

    return $html;
    }

  private function validateCss(string $css) : \HtmlValidator\Response
    {
    if (false === stripos($css, 'html>'))
      {
      $css = '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>Title</title><style>' . $css . '</style></head><body><hr></body></html>';
      }
    $this->throttle->delay();
    $response = self::$validator->validateDocument($css);

    return $response;
    }

  private function validateHtml(string $html) : \HtmlValidator\Response
    {
    if (false === stripos($html, 'html>'))
      {
      $html = '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>Title</title></head><body>' . $html . '</body></html>';
      }
    $this->throttle->delay();
    $response = self::$validator->validateDocument($html);

    return $response;
    }

  }