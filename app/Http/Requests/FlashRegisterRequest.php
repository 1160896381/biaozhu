<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class FlashRegisterRequest extends Request {

	public function authorize()
	{
	  	return true;
	}
	
	public function rules()
	{
	    return [
	        "flashPath" => ['required']
	    ]; 
	}

	public function sanitize()
	{
	    return $this->all();
	}

}
