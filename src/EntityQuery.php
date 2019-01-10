<?php

	namespace Inlm\Model;

	use LeanMapperQuery\Query;
	use LeanMapper\Entity;


	class EntityQuery extends Query implements \Countable
	{
		/** @var Entity */
		private $entity;

		/** @var string */
		private $field;


		public function __construct(Entity $entity, $field)
		{
			$this->entity = $entity;
			$this->field = $field;
		}


		public function find()
		{
			return $this->entity->find($this->field, $this);
		}


		public function findOne()
		{
			return $this->entity->findOne($this->field, $this);
		}


		public function count()
		{
			return $this->entity->findCount($this->field, $this);
		}
	}
