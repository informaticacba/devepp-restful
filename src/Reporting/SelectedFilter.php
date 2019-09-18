<?php
/**
 * Created by PhpStorm.
 * User: Paul.Epp
 * Date: 1/8/2019
 * Time: 10:34 AM
 */

namespace App\Reporting;

use App\Reporting\DatabaseFields\DatabaseField;
use App\Reporting\Filters\Constraints\AbstractConstraint;
use App\Reporting\Selectables\AbstractSelectable;
use JsonSerializable;

class SelectedFilter implements JsonSerializable
{
	/** @var DatabaseField */
	protected $field;

	/** @var string */
	protected $label;

	/** @var AbstractConstraint */
	protected $constraint;

	/** @var array */
	protected $inputs;

	/**
	 * SelectedFilter constructor.
	 * @param DatabaseField $field
	 * @param AbstractConstraint $constraint
	 * @param array $inputs
	 */
	public function __construct(DatabaseField $field, AbstractConstraint $constraint, $inputs = [])
	{
		$this->field = $field;
		$this->constraint = $constraint;
		$this->inputs = $inputs;
	}


	/**
	 * @return array
	 */
	public function jsonSerialize()
	{
		return [
			'name' => $this->name(),
			'label' => $this->label(),
			'aggregate_options' => $this->label(),
		];
	}

	/**
	 * @return string
	 */
	public function name()
	{
		return $this->field->name();
	}

	/**
	 * @return string
	 */
	public function label()
	{
		return $this->field->alias();
	}


	/**
	 * @return string
	 */
	public function table()
	{
		return $this->field->tableAlias();
	}


	/**
	 * @param bool $subQuery
	 * @return string
	 */
	public function filterSql($subQuery = false)
	{
		return $this->constraint->filterSql($this->field, $this->inputs);
	}


	/**
	 * @param bool $subQuery
	 * @return string
	 */
	public function filterAlias($subQuery)
	{
		return $this->constraint->filterAlias($this->field, $subQuery);
	}


}