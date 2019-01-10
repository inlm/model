<?php

	namespace Inlm\Model;

	use LeanMapper\Entity;
	use LeanMapperQuery\Query;


	interface IQueryable
	{
		/**
		 * @return Entity[]
		 */
		public function find(Query $query);


		/**
		 * @return Entity
		 */
		public function findOne(Query $query);


		/**
		 * @return int
		 */
		public function findCount(Query $query);
	}
