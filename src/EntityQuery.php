<?php

	declare(strict_types=1);

	namespace Inlm\Model;

	use LeanMapperQuery\Query;
	use LeanMapper\Entity;


	class EntityQuery extends Query implements \Countable
	{
		/** @var Entity */
		private $entity;

		/** @var string */
		private $field;


		/**
		 * @param string $field
		 */
		public function __construct(Entity $entity, $field)
		{
			$this->entity = $entity;
			$this->field = $field;
		}


		/**
		 * @return Entity[]
		 * @phpstan-return array
		 */
		public function find()
		{
			return $this->entity->find($this->field, $this);
		}


		/**
		 * @return Entity|NULL
		 * @phpstan-return mixed|NULL
		 */
		public function findOne()
		{
			return $this->entity->findOne($this->field, $this);
		}


		public function count(): int
		{
			return $this->entity->findCount($this->field, $this);
		}
	}
