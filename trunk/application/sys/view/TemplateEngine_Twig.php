<?php
	private $PathViews = null;

		
	
	public function View($view, $model = array())
		$twig_loader = new Twig_Loader_Filesystem($this->PathViews);