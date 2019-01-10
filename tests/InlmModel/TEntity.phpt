<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * @property int $id
 * @property Author $author m:hasOne
 * @property int $Id
 * @property int $reviewerId
 */
class Book extends \LeanMapper\Entity
{
	use \Inlm\Model\TEntity;
}


/**
 * @property int $id
 */
class Author extends \LeanMapper\Entity
{
}


test(function () {
	$book = new Book;
	$book->authorId = 100;
	$book->Id = 200;
	$book->reviewerId = 300;

	$data = $book->getRowData();
	Assert::same(100, $book->authorId);
	Assert::same(200, $data['Id']);
	Assert::same(200, $book->Id);
	Assert::same(300, $data['reviewerId']);
	Assert::same(300, $book->reviewerId);
});
