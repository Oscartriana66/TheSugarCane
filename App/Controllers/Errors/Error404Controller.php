<?php

class Error404Controller extends Controller
{
	public function index()
	{
		$this->view('Errors/error404');
	}
}