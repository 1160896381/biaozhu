<?php namespace App\Http\Controllers;

use App\Page;
use App\Auth;

class HomeController extends Controller {

	public function index()
	{
		return view('home');
	}

}
