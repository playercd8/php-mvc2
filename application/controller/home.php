<?php
	public function index()
	public function test1($x="Test1")
	{
		parent::Content($x);
	}
	{
		global $app;
		$app->loadSys('request');
	
		$request = new Request();
	
		parent::Json($request->Headers);
	}