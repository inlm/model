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
			$row = $this->connection->select('*')
				->from($this->getTable())
				->where('%n = ?', $this->mapper->getPrimaryKey($this->getTable()), $id)
				->fetch();

			if ($row === FALSE) {
				return $row;
			}
			return $this->createEntity($row);
		}
	}
