<?php 

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model {

	protected $fillable = ['mimeType', 'fileName', 'updated_at', 'userId', 'fileSize', 'webPath'];

	protected $dates = ['updated_at'];

}
