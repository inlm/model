<?php

declare(strict_types=1);

namespace Inlm\Model\Tests\TQueryableEntity;

use Inlm;
use SqlLogger;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


/**
 * @property int $id
 * @property Book[] $books m:belongsToMany
 */
class Author extends \LeanMapper\Entity
{
	use Inlm\Model\TQueryableEntity;
}


/**
 * @property int $id
 */
class Book extends \LeanMapper\Entity
{
}


class AuthorRepository extends \LeanMapper\Repository
{
	/** @use Inlm\Model\TRepository<Author> */
	use Inlm\Model\TRepository;
}

$connection = createConnection();
$sql = new SqlLogger($connection);
$authorRepository = new AuthorRepository(
	$connection,
	createMapper(__NAMESPACE__),
	createEntityFactory()
);


test(function () use ($authorRepository, $sql) {
	$author = $authorRepository->get(1);
	assert($author !== NULL);
	$sql->reset();
	$books = $author->query('books')
		->orderBy('@id DESC')
		->find();

	Assert::same([
		1,
	], extractIds($books));

	Assert::same([
		'SELECT [book].* FROM [book] WHERE [book].[author_id] IN (1) ORDER BY [book].[id] DESC',
	], $sql->getAll());
});


test(function () use ($authorRepository, $sql) {
	$author = $authorRepository->get(1);
	assert($author !== NULL);
	$sql->reset();
	$book = $author->query('books')
		->orderBy('@id DESC')
		->findOne();

	assert($book !== NULL && isset($book->id));
	Assert::same(1, $book->id);

	Assert::same([
		'SELECT * FROM (SELECT [book].* FROM [book] WHERE [book].[author_id] = 1 ORDER BY [book].[id] DESC LIMIT 1)',
	], $sql->getAll());
});


test(function () use ($authorRepository, $sql) {
	$author = $authorRepository->get(1);
	assert($author !== NULL);
	$sql->reset();
	$book = $author->query('books')
		->where('@id > 9999')
		->findOne();

	Assert::null($book);
});


test(function () use ($authorRepository, $sql) {
	$author = $authorRepository->get(1);
	assert($author !== NULL);
	$sql->reset();
	$count = $author->query('books')
		->orderBy('@id DESC')
		->count();

	Assert::same(1, $count);

	Assert::same([
		'SELECT [book].* FROM [book] WHERE [book].[author_id] IN (1) ORDER BY [book].[id] DESC',
	], $sql->getAll());
});
