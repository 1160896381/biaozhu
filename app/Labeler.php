<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Labeler extends Model {

	use SoftDeletes;

	protected $table = 'labelers';
	
	protected $fillable = ['userId', 'labelerName', 'password', 'email', 'type', 'verify'];

	protected $hidden = ['password', 'remember_token'];

}
