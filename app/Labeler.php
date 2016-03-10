<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Database\Eloquent\SoftDeletes;

class Labeler extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
	
	use SoftDeletes;

	protected $table = 'labelers';
	
	protected $fillable = ['userId', 'labelerName', 'password', 'email'];

	protected $hidden = ['password', 'remember_token'];

	public function hasOneUser()
	{
		return $this->hasOne('App\User', 'id', 'userId');
	}
}
