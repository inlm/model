<?php

	namespace Inlm\Model;

	use LeanMapper\Entity;
	use LeanMapper\Fluent;
	use Inlm\QueryObject;
	use Inlm\QueryObject\IQuery;


	trait TQueryableEntity
	{
		use QueryObject\TEntity;


		/**
		 * Creates base query object
		 * @return EntityQuery
		 */
		public function query($field)
		{
			return new EntityQuery($this, $field);
		}


		/**
		 * Fetchs entities by Query object
		 * @return Entity[]
		 */
		public function find($field, IQuery $query)
		{
			$entities = $this->queryProperty($field, $query);
			return $this->entityFactory->createCollection($entities);
		}


		/**
		 * Fetchs one entity by Query object
		 * @return Entity|FALSE
		 */
		public function findOne($field, IQuery $query)
		{
			$query->limit(1);
			$entities = $this->queryProperty($field, $query);
			if ($entities) {
				return $entities[0];
			}
			return FALSE;
		}


		/**
		 * Fetchs count by Query object
		 * @return int
		 */
		public function findCount($field, IQuery $query)
		{
			return count($this->queryProperty($field, $query));
		}
	}
