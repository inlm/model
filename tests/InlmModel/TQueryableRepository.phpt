<?php

declare(strict_types=1);

namespace Inlm\Model\Tests\TQueryableRepository;

use Inlm;
use SqlLogger;
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
	use Inlm\Model\TQueryableRepository;
}

$connection = createConnection();
$sql = new SqlLogger($connection);
$bookRepository = new BookRepository(
	$connection,
	createMapper(__NAMESPACE__),
	createEntityFactory()
);


test(function () use ($bookRepository, $sql) {
	$sql->reset();
	$books = $bookRepository->query()
		->orderBy('@id DESC')
		->find();

	Assert::same([
		5,
		4,
		3,
		2,
		1,
	], extractIds($books));

	Assert::same([
		'SELECT [book].* FROM [book] ORDER BY [book].[id] DESC',
	], $sql->getAll());
});


test(function () use ($bookRepository, $sql) {
	$sql->reset();
	$book = $bookRepository->query()
		->orderBy('@id DESC')
		->findOne();

	Assert::same(5, $book->id);

	Assert::same([
		'SELECT [book].* FROM [book] ORDER BY [book].[id] DESC LIMIT 1',
	], $sql->getAll());
});


test(function () use ($bookRepository, $sql) {
	$sql->reset();
	$book = $bookRepository->query()
		->where('@id > 9999')
		->findOne();

	Assert::null($book);
});


test(function () use ($bookRepository, $sql) {
	$sql->reset();
	$count = $bookRepository->query()
		->orderBy('@id DESC')
		->count();

	Assert::same(5, $count);

	Assert::same([
		'SELECT COUNT(*) FROM ( SELECT [book].* FROM [book] ORDER BY [book].[id] DESC ) [data]',
	], $sql->getAll());
});
