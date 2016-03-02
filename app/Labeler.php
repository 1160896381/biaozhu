<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Labeler extends Model {

	use SoftDeletes;

	protected $fillable = ['userId', 'labelerName', 'password', 'salt', 'email', 'type', 'verify'];

}
