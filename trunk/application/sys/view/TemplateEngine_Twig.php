<?phpclass TemplateEngine_Twig{	//模板引擎 (PATH_VIEWS, PATH_VIEW_FILE_TYPE 定義在 \application\config\config.php )
	private $PathViews = null;	private $ViewFileType = null;
	function __construct()	{		$this->PathViews = PATH_VIEWS;		$this->ViewFileType = PATH_VIEW_FILE_TYPE;
				if (!class_exists("Twig_Loader_Filesystem")) {			die('TemplateEngine Twig is not installed');		}	}
	
	public function View($view, $model = array())	{
		$twig_loader = new Twig_Loader_Filesystem($this->PathViews);		$twig = new Twig_Environment($twig_loader);		echo $twig->render($view . $this->ViewFileType, $model);	}}
