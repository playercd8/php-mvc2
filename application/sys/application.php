<?php
defined('_PHPMVC2') or die;

final class Application {
	/** @var null The controller */
	private $url_controller = null;

	/** @var null The method (of the above controller), often also named "action" */
	private $url_action = null;

	private $url_argc = null;
	
	private $url_argv = null;
	

    public function __construct() {
	}
	 
	/**
	 * "Start" the application:
 	 * Analyze the URL elements and calls the according controller/method or the fallback
	 */
	public function run() {
		// create array with URL parts in $url
		$this->splitUrl();
		
		$path = _AppPath.'/controller/' . $this->url_controller . '.php';

        // check for controller: does such a controller exist ?
        if (file_exists($path)) {

            // if so, then load this file and create this controller
            // example: if controller would be "car", then this line would translate into: $this->car = new car();
            require_once $path;
            
            // create the reflection class
            $rc = new ReflectionClass( $this->url_controller );
            
            // check for method: does such a method exist in the controller ?
			if ($rc->hasMethod($this->url_action) && 
				$rc->getMethod($this->url_action)->isPublic() ) {

                // call the method and pass the arguments to it
            	$rps = $rc->getMethod($this->url_action)->getParameters();
            	
            	if (count($rps) != 0) {
	            	$arguments = array();
	            	$n = 0;
	            	foreach( $rps as $param ) {
	            		$paramName = $param->getName();
	            		
	            		if (array_key_exists($paramName, $this->url_argv)) {	            			$arguments[] = $this->url_argv[ $paramName ];	            		}
	            		else if (array_key_exists($n, $this->url_argv)) {
	            			$arguments[] = $this->url_argv[ $n ];
	            			$n += 1;
	            		}
	            		else if ($param->isDefaultValueAvailable()) {
	            			$arguments[] = $param->getDefaultValue();
	            		}
	            		else if( ! $param->isOptional() && ! $param->allowsNull() ) {
	            			throw new Exception('parameter is not defined.');
	            		}
	            	}
	            	call_user_func_array(array($this->url_controller, $this->url_action), $arguments);            	
            	}
            	else {
            		call_user_func(array($this->url_controller, $this->url_action));
            	}
            } else {
                // default/fallback: call the index() method of a selected controller
            	call_user_func(array($this->url_controller, 'index'));
            }
        } else {
            // invalid URL, so simply show home/index
            require _AppPath.'/controller/home.php';
            $home = new Home();
            $home->index();
        }
    }

    /**
     * Get and split the URL
     */
    private function splitUrl() {
        if (isset($_GET['url'])) {

            // split URL
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->url_controller = (isset($url[0]) ? $url[0] : null);
            $this->url_action = (isset($url[1]) ? $url[1] : null);
			
            //URL mode
			$length = count($url);
			if ($length > 2) {
				$this->url_argc = $length - 2;
				array_shift($url);
				array_shift($url);
				$this->url_argv = $url;				
			} else {
				$this->url_argc = 0;
				$this->url_argv = array();
			}
			
			//GET mode
			$length = count($_GET);
			if ($length > 1) {
				$this->url_argc += ($length - 1);
				foreach ($_GET as $k => $v) {
					if ($k != 'url') {
						$this->url_argv[$k] = $v;
					}
				}
			}
			
			//POST mode
			if (isset($_POST)) {
				$length = count($_POST);
				if ($length > 0) {
					$this->url_argc += $length;
					$this->url_argv += $_POST;
				}
			}
        }
    }
    
    public function loadSys($lib) {
    	if (is_string($lib)) {
    		$path = _AppPath.'/sys/' . $lib . '.php';
    		if (file_exists($path)) {
    			require_once $path;
    		} else {
    			die ("Can not Load $path");
    		}
    	}
    }
    
    public function loadLib($lib) {    	if (is_string($lib)) {
    		$path = _AppPath.'/libs/' . $lib . '.php';
    		if (file_exists($path)) {
    			require_once $path;
    		} else {
    			die ("Can not Load $path");
    		}
    	} else if (is_array($lib)) {
    		foreach ($lib as $lib1) {
    			if (is_string($lib1)) {
    				$path = _AppPath.'/libs/' . $lib1 . '.php';
    				if (file_exists($path)) {
    					require_once $path;
    				} else {
    					die ("Can not Load $path");
    				}
    			}
    		}
    	}
    }
}
