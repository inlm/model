<?php

	namespace Inlm\Model;

	use LeanMapper\Entity;
	use LeanMapper\Fluent;
	use Inlm\QueryObject\IQuery;


	trait TQueryableRepository
	{
		/**
		 * Creates base query object
		 * @return RepositoryQuery
		 */
		public function query()
		{
			return new RepositoryQuery($this);
		}


		/**
		 * Fetchs entities by Query object
		 * @return Entity[]
		 */
		public function find(IQuery $query)
		{
			return $this->createEntities($this->applyQuery($query)->fetchAll());
		}


		/**
		 * Fetchs one entity by Query object
		 * @return Entity|FALSE
		 */
		public function findOne(IQuery $query)
		{
			$row = $this->apply($query)
				->removeClause('limit')
				->removeClause('offset')
				->fetch();
			return $row ? $this->createEntity($row) : FALSE;
		}


		/**
		 * Fetchs count by Query object
		 * @return int
		 */
		public function findCount(IQuery $query)
		{
			return count($this->applyQuery($query));
		}


		/**
		 * @return Fluent
		 */
		protected function applyQuery(IQuery $query)
		{
			$fluent = $this->createFluent();
			$query->applyQuery($fluent, $this->mapper);
			return $fluent;
		}
	}
