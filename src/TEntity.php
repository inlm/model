<?php

	namespace Inlm\Model;

	use LeanMapper\Entity;
	use LeanMapper\Filtering;
	use LeanMapper\Fluent;


	trait TEntity
	{
		use TEntityRowValue;


		public function __set($name, $value)
		{
			if ($name !== 'Id' && substr($name, -2) === 'Id') {
				$this->setRowValue(substr($name, 0, -2), $value);

			} else {
				parent::__set($name, $value);
			}
		}


		public function __get($name)
		{
			if ($name !== 'Id' && substr($name, -2) === 'Id') {
				return $this->getRowValue(substr($name, 0, -2));
			}
			return parent::__get($name);
		}
	}
