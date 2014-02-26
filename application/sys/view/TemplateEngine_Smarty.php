<?phpclass TemplateEngine_Smarty{
	//模板引擎 (PATH_VIEWS, PATH_VIEW_FILE_TYPE 定義在 \application\config\config.php )
	private $PathViews = null;
	private $ViewFileType = null;
	
	function __construct()	{		$this->PathViews = PATH_VIEWS;		$this->ViewFileType = PATH_VIEW_FILE_TYPE;
		global $app;		$app.loadLib('Smarty/Smarty.class');	}
	public function View($view, $model = array())	{		$tpl = new Smarty();		$path = $this->PathViews . $view . $this->ViewFileType;		$tpl->assign("model", $model);		$tpl->display($path);	}
}
