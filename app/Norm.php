<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Norm extends Model {

	protected $fillable = ['flashId', 'userId', 'zeroLevel', 'firstLevel', 'secondLevel'];

}
