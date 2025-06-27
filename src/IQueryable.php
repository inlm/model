<?php

	declare(strict_types=1);

	namespace Inlm\Model;

	use LeanMapper\Entity;
	use LeanMapperQuery\Query;


	/**
	 * @template T of \LeanMapper\Entity
	 */
	interface IQueryable
	{
		/**
		 * @param Query<T> $query
		 * @return T[]
		 */
		public function find(Query $query);


		/**
		 * @param Query<T> $query
		 * @return T|NULL
		 */
		public function findOne(Query $query);


		/**
		 * @param Query<T> $query
		 * @return int
		 */
		public function findCount(Query $query);
	}
