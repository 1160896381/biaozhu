<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Flash extends Model {

	protected $fillable = ['classId', 'superId', 'hasNorm', 'hasBS', 'flashPath', 'flashPathBS'];

	public function belongsToNorm()
	{
		return $this->belongsTo('App\Norm', 'id');
	}

}
