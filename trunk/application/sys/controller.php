<?php
defined('_PHPMVC2') or die;
/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */
class Controller
{
    /**
     * @var null Database Connection
     */
    private static $db = null;
	
    //模板引擎 (Template_Engine 定義在 \application\config\config.php )
    public static $TemplateEngine = Template_Engine;
    
    /**
     * Whenever a controller is created, open a database connection too. The idea behind is to have ONE connection
     * that can be used by multiple models (there are frameworks that open one connection per model).
     */
    function __construct()
    {

    }
	
	/**
     * Open the database connection with the credentials from application/config/config.php
	*/
	protected function getDB()
    {
		require_once _AppPath.'/sys/db/Database.php';
	
		if (isset(self::$db)) {
			return self::$db;
		} else {
			if (DB_TYPE == 'mysql') {
				$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
			}
			else {
				$options = array();
			}
			self::$db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS, $options);
			return self::$db;
		}
    }
	
    /**
     * Load the model with the given name.
     * loadModel("SongModel") would include models/songmodel.php and create the object in the controller, like this:
     * $songs_model = $this->loadModel('SongsModel');
     * Note that the model class name is written in "CamelCase", the model's filename is the same in lowercase letters
     * @param string $model_name The name of the model
     * @return object model
     */
	protected function loadModel($model_name, $use_db = true)
	{
		$path = _AppPath.'/models/' . strtolower($model_name) . '.php';
		if (file_exists($path)) {
			require_once $path;
		} else {
			die ("Can not loadModel $path");
		}
			
		// return new model (and pass the database connection to the model)
		if ($use_db == true) {
			return new $model_name($this->getDB());			
		} else {
			return new $model_name();
		}
	}
	
	//protected $IsPostBack = null;
	
	protected $Request = null;
	protected function getRequest() {
		if (empty($this->Request) ) {
			global $app;
			$app->loadSys('request');			
			$this->Request = new Request();			
		}
		return $this->Request;
	}
	
	
	protected function Xml($xml) 
	{
		header('Content-type: text/xml; charset=utf-8');
		echo $xml;
		
		exit;
	}
	
	protected function Json($json)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($json);
		
		exit;
	}
	
	protected function JavaScript($script)
	{
		header('Content-Type: application/javascript; charset=utf-8');
		echo $script;
		
		exit;
	}
	
	protected function Redirect($url) 
	{
		header('HTTP/1.1 301 Moved Permanently');
		header("Location: $url");
		
		exit;
	}
	
	protected function Content($text)
	{
		header('Content-type: text/plain; charset=utf-8');
		echo $text;
		
		exit;
	}
	
	protected function File($file, $filename = null)
	{
		if (file_exists($file)) {
			header('Content-type: application/octet-stream');

			if (isset($filename)) {
				header('Content-Disposition: attachment; filename="'.$filename.'"');
			}
		
			readfile($file);
			
			exit;
		} else {
			die("file is not exist");
		}
	}
	
	protected function View($view, $model = array())
	{
		header('Content-Type:text/html; charset=utf-8');
		
		$TemplateEngineName = 'TemplateEngine_'.self::$TemplateEngine;
		
		global $app;
		$app->loadSys('view/'.$TemplateEngineName);

		$tpl = new $TemplateEngineName();
		$tpl->View($view, $model);
	
		exit;
	}
	
	protected function IsPostBack() {
		if (isset($_POST) && 
			(count($_POST) > 0)) {
			return true;
		}
		return false;
	}
}
