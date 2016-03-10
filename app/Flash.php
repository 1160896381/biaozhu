<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Flash extends Model {

	protected $fillable = ['classId', 'superId', 'hasNorm', 'hasBS', 'flashPath', 'flashPathBS'];

}
