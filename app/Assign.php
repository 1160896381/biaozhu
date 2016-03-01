<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assign extends Model {

	use SoftDeletes;

	protected $fillable = ['classId', 'userId', 'title', 'claim', 'state', 'state2', 'finishTime', 'deadTime', 'labeler', 'receiver', 'initXml', 'xml', 'content'];

	protected $dates = ['updated_at', 'deleted_at', 'finishTime', 'deadTime'];
}
