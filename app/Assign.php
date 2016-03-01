<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assign extends Model {

	use SoftDeletes;

	protected $fillable = array('*');
}
