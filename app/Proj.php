<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Proj extends Model {

	protected $fillable = ['name', 'superId', 'description'];

	public function belongsToSuper()
	{
		return $this->belongsTo('App\Super', 'superId');
	}
}
