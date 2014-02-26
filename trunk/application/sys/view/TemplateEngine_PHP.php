<?php
class TemplateEngine_PHP
{
	//模板引擎 (PATH_VIEWS, PATH_VIEW_FILE_TYPE 定義在 \application\config\config.php )
	private $PathViews = null;
	private $ViewFileType = null;

	function __construct()
	{		$this->PathViews = PATH_VIEWS;		$this->ViewFileType = PATH_VIEW_FILE_TYPE;	}

	public function View($view, $model = array())
	{		$path = $this->PathViews . $view . $this->ViewFileType;
		if (file_exists($path)) {			include_once $path;
		} else {			die ("Can not Load $path");
		}	}
}