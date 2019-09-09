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

class ErrorConstraint extends \PHPUnit\Framework\Constraint\Constraint
	{
	/**
	* Returns a string representation of the constraint.
	*
	*/
	public function toString() : string
		{
		return 'is valid';
		}

	/**
	* Return additional failure description where needed.
	*
	* The function can be overridden to provide additional failure
	* information like a diff
	*
	* @param mixed $other Evaluated value or object.
	*
	*/
	protected function additionalFailureDescription($other) : string
		{
		return implode("\n", $other->getErrors());
		}

	/**
	* Returns the description of the failure.
	*
	* The beginning of failure messages is "Failed asserting that" in most
	* cases. This method should return the second part of that sentence.
	*
	* @param mixed $other Evaluated value or object.
	*
	*/
	protected function failureDescription($other) : string
		{
		return 'the markup ' . $this->toString();
		}

	/**
	* Evaluates the constraint for parameter $other. Returns TRUE if the
	* constraint is met, FALSE otherwise.
	*
	* @param mixed $other Value or object to evaluate.
	*
	*/
	protected function matches($other) : bool
		{
		return ! $other->hasErrors();
		}

	}
