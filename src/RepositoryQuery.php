<?php

	declare(strict_types=1);

	namespace Inlm\Model;

	use LeanMapperQuery\Query;
	use LeanMapper\Entity;
	use LeanMapper\Repository;


	/**
	 * @phpstan-template T of \LeanMapper\Entity
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
		 * @return Entity[]
		 * @phpstan-return T[]
		 */
		public function find()
		{
			return $this->repository->find($this);
		}


		/**
		 * @return Entity|NULL
		 * @phpstan-return T|NULL
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
