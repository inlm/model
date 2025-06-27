<?php

	declare(strict_types=1);

	namespace Inlm\Model;

	use LeanMapper\Entity;
	use LeanMapper\Filtering;
	use LeanMapper;


	trait TEntityRowValue
	{
		/**
		 * @param  string $field
		 * @param  mixed $value
		 * @return void
		 * @see http://forum.dibiphp.com/cs/14592-lean-mapper-tenke-orm-nad-dibi?p=3#p105515
		 */
		public function setRowValue($field, $value)
		{
			$property = $this->getCurrentReflection()->getEntityProperty($field);

			if (
				$property !== NULL &&
				$property->hasRelationship() &&
				($property->getRelationship() instanceof LeanMapper\Relationship\HasOne)
			) {
				if ($value === NULL && !$property->isNullable()) {
					throw new LeanMapper\Exception\InvalidArgumentException("Property '$field' is not nullable.");

				} elseif (!is_scalar($value) && $value !== NULL) {
					throw new LeanMapper\Exception\InvalidArgumentException("Value for property '$field' must be scalar or NULL, " . gettype($value) . " given");
				}
				$relationship = $property->getRelationship();
				$this->row->{$relationship->getColumnReferencingTargetTable()} = $value;
				$this->row->cleanReferencedRowsCache($relationship->getTargetTable(), $relationship->getColumnReferencingTargetTable());

			} else {
				throw new LeanMapper\Exception\InvalidArgumentException("Property '$field' has not HasOne relationship.");
			}
		}


		/**
		 * @param  string $field
		 * @return mixed
		 */
		public function getRowValue($field)
		{
			$property = $this->getCurrentReflection()->getEntityProperty($field);

			if ($property !== NULL && $property->hasRelationship() && ($property->getRelationship() instanceof \LeanMapper\Relationship\HasOne)) {
				return $this->row->{$property->getColumn()};// TODO: ?? $relationshop->getColumnReferencingTargetTable()
			}

			throw new LeanMapper\Exception\InvalidArgumentException("Property '$field' has not HasOne relationship.");
		}
	}
