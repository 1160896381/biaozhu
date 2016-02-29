<?php 

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model {

	protected $fillable = ['mimeType', 'fileName', 'updated_at', 'userId', 'fileSize', 'webPath'];

	protected $dates = ['updated_at', 'deleted_at'];

}
