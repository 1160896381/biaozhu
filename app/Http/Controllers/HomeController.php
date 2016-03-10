<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	public function index()
	{	
		return view('home');
	}

	public function deleteCookie()
	{
		\Cookie::queue('labeler', null , -1);
		\Cookie::queue('super', null , -1);
	}

}
