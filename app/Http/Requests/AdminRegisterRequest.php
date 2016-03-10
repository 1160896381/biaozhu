<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminRegisterRequest extends Request {

	public function authorize()
	{
	  	return true;
	}
	
	public function rules()
	{
	    return [
	        "name" => ['required','min:3','max:16','unique:users'],
	        "password" => ['required','min:6','max:16','confirmed'],
	        "email" => ['required', 'unique:users', 'email']
	    ]; 
	}

	public function sanitize()
	{
	    return $this->all();
	}

}
