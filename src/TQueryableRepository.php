<?php

	declare(strict_types=1);

	namespace Inlm\Model;

	use LeanMapper\Entity;
	use LeanMapper\Fluent;
	use LeanMapperQuery\Query;


	/**
	 * @phpstan-template T of \LeanMapper\Entity
	 */
	trait TQueryableRepository
	{
		/**
		 * Creates base query object
		 * @return RepositoryQuery
		 * @phpstan-return RepositoryQuery<T>
		 */
		public function query()
		{
			return new RepositoryQuery($this);
		}


		/**
		 * Fetchs entities by Query object
		 * @param  Query<T> $query
		 * @return iterable<Entity>
		 * @phpstan-return iterable<T>
		 */
		public function find(Query $query)
		{
			return $this->createEntities($this->applyQuery($query)->fetchAll());
		}


		/**
		 * Fetchs one entity by Query object
		 * @param  Query<T> $query
		 * @return Entity|NULL
		 * @phpstan-return T|NULL
		 */
		public function findOne(Query $query)
		{
			$row = $this->applyQuery($query)
				->removeClause('limit')
				->removeClause('offset')
				->fetch();
			return $row ? $this->createEntity($row) : NULL;
		}


		/**
		 * Fetchs count by Query object
		 * @param  Query<T> $query
		 * @return int
		 */
		public function findCount(Query $query)
		{
			return count($this->applyQuery($query));
		}


		/**
		 * @param  Query<T> $query
		 * @return Fluent
		 */
		protected function applyQuery(Query $query)
		{
			$fluent = $this->createFluent();
			$query->applyQuery($fluent, $this->mapper);
			return $fluent;
		}
	}
