<?php

	namespace Inlm\Model;

	use LeanMapper\Entity;


	trait TRepository
	{
		/**
		 * Creates new empty (detached) entity
		 * @return Entity
		 */
		public function createNewEntity()
		{
			$entityClass =  $this->mapper->getEntityClass($this->getTable());
			return $this->entityFactory->createEntity($entityClass);
		}


		/**
		 * Fetchs entity by primary key
		 * @return Entity|FALSE
		 */
		public function get($id)
		{
			return $this->getByColumn($this->mapper->getPrimaryKey($this->getTable()), $id);
		}


		/**
		 * Fetchs entity by primary key
		 * @return Entity|FALSE
		 */
		protected function getByColumn($column, $value)
		{
			$row = $this->connection->select('*')
				->from($this->getTable())
				->where('%n = ?', $column, $value)
				->fetch();

			if ($row === FALSE) {
				return $row;
			}
			return $this->createEntity($row);
		}
	}
