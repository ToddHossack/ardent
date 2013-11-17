<?php namespace LaravelBook\Ardent\Relations;

use Illuminate\Database\Eloquent\Model;

class BelongsToMany extends \Illuminate\Database\Eloquent\Relations\BelongsToMany {

	/**
	 * Save a new model and attach it to the parent model.
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @param  array  $joining
	 * @param  bool   $touch
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function save(Model $model, array $joining = array(), $touch = true)
	{
		$result = $model->save(array('touch' => false));

		if($result) $this->attach($model->getKey(), $joining, $touch);

		return $model;
	}

	/**
	 * Create a new instance of the related model.
	 *
	 * @param  array  $attributes
	 * @param  array  $joining
	 * @param  bool   $touch
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function create(array $attributes, array $joining = array(), $touch = true)
	{
		$instance = $this->related->newInstance($attributes);

		// Once we save the related model, we need to attach it to the base model via
		// through intermediate table so we'll use the existing "attach" method to
		// accomplish this which will insert the record and any more attributes.
		$result = $instance->save(array('touch' => false));

		if($result) $this->attach($instance->getKey(), $joining, $touch);

		return $instance;
	}


}