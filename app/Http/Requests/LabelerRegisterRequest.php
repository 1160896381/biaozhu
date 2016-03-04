<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class LabelerRegisterRequest extends Request {

	public function authorize()
	{
	  	return true;
	}
	
	public function rules()
	{
	    return [
	        "labelerName" => ['required','min:3','max:16','unique:labelers'],
	        "password" => ['required','min:6','max:16','confirmed'],
	        "email" => ['required', 'unique:labelers']
	    ]; 
	}

	public function sanitize()
	{
	    return $this->all();
	}

}
