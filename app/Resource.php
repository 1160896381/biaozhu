<?php 

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model {
	
	use SoftDeletes;

	protected $fillable = ['mimeType', 'fileName', 'fileReal', 'updated_at', 'userId', 'fileSize', 'subPath', 'webPath', 'deleted_at'];

	protected $dates = ['updated_at', 'deleted_at'];

}
