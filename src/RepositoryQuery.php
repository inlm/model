<?php

	namespace Inlm\Model;

	use Inlm\QueryObject\Query;
	use LeanMapper\Repository;


	class RepositoryQuery extends Query implements \Countable
	{
		/** @var Repository */
		private $repository;


		public function __construct(Repository $repository)
		{
			$this->repository = $repository;
		}


		public function find()
		{
			return $this->repository->find($this);
		}


		public function findOne()
		{
			return $this->repository->findOne($this);
		}


		public function count()
		{
			return $this->repository->findCount($this);
		}
	}
