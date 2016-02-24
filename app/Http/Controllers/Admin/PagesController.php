<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Page;

use Redirect, Input, Auth;

class PagesController extends Controller {

	public function create()
	{
		return view('admin.pages.create');
	}

	public function store()
	{
		$this->validate($request, [
			'title' => 'required|unique:pages|max:255',
			'body' => 'required',
		]);

		$page = new Page;
		$page->title = Input::get('title');
		$page->body = Input::get('body');
		$page->user_id = 1;

		if ($page->save()) {
			return Redirect::to('admin');
		} else {
			return Redirect::back()->withInput()->withErrors('保存失败！');
		}

	}

	public function edit($id)
	{
		return view('admin.pages.edit')->withPage(Page::find($id));
	}

	public function destroy($id)
	{
		$page = Page::find($id);
		$page->delete();

		return Redirect::to('admin');
	}

}
