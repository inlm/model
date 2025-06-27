<?php

	declare(strict_types=1);

	namespace Inlm\Model;

	use LeanMapperQuery\Query;
	use LeanMapper\Entity;
	use LeanMapper\Repository;


	/**
	 * @template T of \LeanMapper\Entity
	 * @extends Query<T>
	 */
	class RepositoryQuery extends Query implements \Countable
	{
		/** @var Repository */
		private $repository;


		public function __construct(Repository $repository)
		{
			$this->repository = $repository;
		}


		/**
		 * @return iterable<T>
		 */
		public function find()
		{
			return $this->repository->find($this);
		}


		/**
		 * @return T|NULL
		 */
		public function findOne()
		{
			return $this->repository->findOne($this);
		}


		public function count(): int
		{
			return (int) $this->repository->findCount($this);
		}
	}
