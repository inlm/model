<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function createConnection()
{
	return new LeanMapper\Connection([
		'driver' => 'sqlite3',
		'database' => __DIR__ . '/db/library.sq3',
	]);
}


function createMapper()
{
	return new TestMapper;
}


function createEntityFactory()
{
	return new LeanMapper\DefaultEntityFactory;
}


function extractIds(array $entities)
{
	$ids = [];

	foreach ($entities as $entity) {
		$ids[] = $entity->id;
	}

	return $ids;
}


function test($cb)
{
	$cb();
}


class TestMapper extends LeanMapper\DefaultMapper
{
	protected $defaultEntityNamespace = NULL;
}


class SqlLogger
{
	private $sqls = [];


	public function __construct(LeanMapper\Connection $connection)
	{
		$connection->onEvent[] = function ($event) {
			$this->add($event->sql);
		};
	}


	public function reset()
	{
		$this->sqls = [];
	}


	public function add($sql)
	{
		$this->sqls[] = $sql;
	}


	public function getAll()
	{
		return $this->sqls;
	}
}
