<?php

declare(strict_types=1);

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * @property int $id
 */
class Book extends \LeanMapper\Entity
{
}


class BookRepository extends \LeanMapper\Repository
{
	use Inlm\Model\TRepository;
}


$bookRepository = new BookRepository(
	createConnection(),
	createMapper(),
	createEntityFactory()
);


test(function () use ($bookRepository) {
	$book = $bookRepository->createNewEntity();
	Assert::true($book->isDetached());
	Assert::same([], $book->getRowData());

	$book->id = 1;
	Assert::same([
		'id' => 1,
	], $book->getData());
});


test(function () use ($bookRepository) {
	$book = $bookRepository->get(1);
	Assert::false($book->isDetached());
	Assert::same([
		'id' => 1,
	], $book->getData());
});


test(function () use ($bookRepository) {
	$book = $bookRepository->get(9999);
	Assert::null($book);
});
