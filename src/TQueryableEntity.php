<?php

	namespace Inlm\Model;

	use LeanMapper\Entity;
	use LeanMapper\Fluent;
	use LeanMapperQuery;
	use LeanMapperQuery\Query;


	trait TQueryableEntity
	{
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
		public function find($field, Query $query)
		{
			$entities = LeanMapperQuery\Entity::queryEntityProperty($this, $field, $query);
			return $this->entityFactory->createCollection($entities);
		}


		/**
		 * Fetchs one entity by Query object
		 * @return Entity|NULL
		 */
		public function findOne($field, Query $query)
		{
			$query->limit(1);
			$entities = LeanMapperQuery\Entity::queryEntityProperty($this, $field, $query);
			if ($entities) {
				return $entities[0];
			}
			return NULL;
		}


		/**
		 * Fetchs count by Query object
		 * @return int
		 */
		public function findCount($field, Query $query)
		{
			return count(LeanMapperQuery\Entity::queryEntityProperty($this, $field, $query));
		}
	}
