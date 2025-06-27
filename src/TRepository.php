<?php

	declare(strict_types=1);

	namespace Inlm\Model;

	use LeanMapper\Entity;


	/**
	 * @phpstan-template T of \LeanMapper\Entity
	 */
	trait TRepository
	{
		/**
		 * Creates new empty (detached) entity
		 * @return Entity
		 * @phpstan-return T
		 */
		public function createNewEntity()
		{
			$entityClass =  $this->mapper->getEntityClass($this->getTable());
			return $this->entityFactory->createEntity($entityClass);
		}


		/**
		 * Fetchs entity by primary key
		 * @param  mixed $id
		 * @return Entity|NULL
		 * @phpstan-return T|NULL
		 */
		public function get($id)
		{
			return $this->getByColumn($this->mapper->getPrimaryKey($this->getTable()), $id);
		}


		/**
		 * Fetchs entity by column value
		 * @param  string $column
		 * @param  mixed $value
		 * @return Entity|NULL
		 * @phpstan-return T|NULL
		 */
		protected function getByColumn($column, $value)
		{
			$row = $this->connection->select('*')
				->from($this->getTable())
				->where('%n = ?', $column, $value)
				->fetch();

			return $row ? $this->createEntity($row) : NULL;
		}
	}
