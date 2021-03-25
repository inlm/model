<?php

	namespace Inlm\Model;

	use LeanMapperQuery\Query;
	use LeanMapper\Entity;
	use LeanMapper\Repository;


	class RepositoryQuery extends Query implements \Countable
	{
		/** @var Repository */
		private $repository;


		public function __construct(Repository $repository)
		{
			$this->repository = $repository;
		}


		/**
		 * @return Entity[]
		 */
		public function find()
		{
			return $this->repository->find($this);
		}


		/**
		 * @return Entity|NULL
		 */
		public function findOne()
		{
			return $this->repository->findOne($this);
		}


		/**
		 * @return int
		 */
		public function count()
		{
			return $this->repository->findCount($this);
		}
	}
