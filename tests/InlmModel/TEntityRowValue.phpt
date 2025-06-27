<?php

declare(strict_types=1);

namespace Inlm\Model\Tests\TEntityRowValue;

use Inlm;
use LeanMapper;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * @property int $id
 * @property Author $author m:hasOne
 * @property Author|NULL $authorWithNull m:hasOne
 */
class Book extends \LeanMapper\Entity
{
	use \Inlm\Model\TEntityRowValue;
}


/**
 * @property int $id
 */
class Author extends \LeanMapper\Entity
{
}


test(function () {
	$book = new Book;
	$book->setRowValue('author', 111);
	Assert::same(111, $book->getRowValue('author'));
});


test(function () {
	$book = new Book;
	$book->authorWithNull = NULL;

	Assert::exception(function () use ($book) {
		$book->setRowValue('author', NULL);
	}, LeanMapper\Exception\InvalidArgumentException::class, "Property 'author' is not nullable.");
});


test(function () {
	$book = new Book;

	Assert::exception(function () use ($book) {
		$book->setRowValue('author', []);
	}, LeanMapper\Exception\InvalidArgumentException::class, "Value for property 'author' must be scalar or NULL, array given");
});


test(function () {
	$book = new Book;

	Assert::exception(function () use ($book) {
		$book->setRowValue('id', 100);
	}, LeanMapper\Exception\InvalidArgumentException::class, "Property 'id' has not HasOne relationship.");

	Assert::exception(function () use ($book) {
		$book->getRowValue('id', 100);
	}, LeanMapper\Exception\InvalidArgumentException::class, "Property 'id' has not HasOne relationship.");
});
