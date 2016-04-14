<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Norm extends Model {

	protected $fillable = ['flashId', 'superId', 'zeroLevel', 'firstLevel', 'secondLevel'];

	public function belongsToFlash()
	{
		return $this->belongsTo('App\Flash', 'flashId');
	}

	public function belongsToSuper()
	{
		return $this->belongsTo('App\Super', 'superId');
	}
}
