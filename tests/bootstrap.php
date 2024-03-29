<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function createConnection(): LeanMapper\Connection
{
	return new LeanMapper\Connection([
		'driver' => 'sqlite3',
		'database' => __DIR__ . '/db/library.sq3',
	]);
}


function createMapper(): LeanMapper\DefaultMapper
{
	return new LeanMapper\DefaultMapper(NULL);
}


function createEntityFactory(): LeanMapper\DefaultEntityFactory
{
	return new LeanMapper\DefaultEntityFactory;
}


/**
 * @param  LeanMapper\Entity[] $entities
 * @return int[]
 */
function extractIds(array $entities)
{
	$ids = [];

	foreach ($entities as $entity) {
		if (!isset($entity->id)) {
			throw new \RuntimeException("Missing column 'id'.");
		}

		$ids[] = $entity->id;
	}

	return $ids;
}


function test(callable $cb): void
{
	$cb();
}


class SqlLogger
{
	/** @var string[] */
	private $sqls = [];


	public function __construct(LeanMapper\Connection $connection)
	{
		$connection->onEvent[] = function ($event) {
			$this->add($event->sql);
		};
	}


	public function reset(): void
	{
		$this->sqls = [];
	}


	public function add(string $sql): void
	{
		$this->sqls[] = $sql;
	}


	/**
	 * @return string[]
	 */
	public function getAll(): array
	{
		return $this->sqls;
	}
}
