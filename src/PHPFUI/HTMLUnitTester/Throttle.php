<?php

/*
 * This file is part of the HTMLUnitTester package.
 *
 * (c) Bruce Wells <brucekwells@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPFUI\HTMLUnitTester;

/**
 * Simple Throttle class.  Call $throttle->delay() to wait the
 * minimum number of microseconds specified in the constructor.
 *
 * Default constructor does not result in any delay.
 */
class Throttle
  {

  private $lastAccessed = 0;
  private $microseconds = 0;

  /**
   * There are 1 million microsecond in a second.
   */
  public function __construct(int $microseconds = 0)
    {
    $this->lastAccessed = microtime(true);
    if ($microseconds)
      {
      $this->microseconds = 1 / 1000000 * $microseconds;
      }
    }

  /**
   * Wait at least the number of microseconds since the last
   * delay call.
   */
  public function delay() : void
    {
    if ($this->microseconds)
      {
      $now = microtime(true);
      $timeDifference = $now - $this->lastAccessed;

      if ($timeDifference < $this->microseconds)
        {
        usleep(($this->microseconds - $timeDifference) * 1000000);
        }
      $this->lastAccessed = $now = microtime(true);
      }
    }

  }
