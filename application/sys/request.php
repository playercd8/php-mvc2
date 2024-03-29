<?php
defined('_PHPMVC2') or die;

final class Request {
	
 	public function __get($varName) {
        if (method_exists($this, $MethodName='get'.$varName)) {
            return $this->$MethodName();
        } else {
            trigger_error($varName.' is not avaliable .',E_USER_ERROR);
        }
    }
    
    //Gets a string array of client-supported MIME accept types.
    //private $AcceptTypes = null;
    
    //Gets the anonymous identifier for the user, if present.   
    //private $AnonymousID = null;

    //Gets the ASP.NET application's virtual application root path on the server.
    //private $ApplicationPath = null;

    //Gets the virtual path of the application root and makes it relative by using the tilde (~) notation for the application root (as in "~/page.aspx").
    //private	$AppRelativeCurrentExecutionFilePath = null;	
	
	//Gets or sets information about the requesting client's browser capabilities.
    //private	$Browser = null;    
    
    //Gets the current request's client security certificate.
    //private $ClientCertificate = null;	
    
	//Gets or sets the character set of the entity-body.
    //private $ContentEncoding = null;
    
	//Specifies the length, in bytes, of content sent by the client.
    //private $ContentLength = null;
    
	//Gets or sets the MIME content type of the incoming request.
    //private $ContentType = null;
    	
	//Gets a collection of cookies sent by the client.
    //private $Cookies = null;
    	
	//Gets the virtual path of the current request.
    //private $CurrentExecutionFilePath = null;
	
	//Gets the extension of the file name that is specified in the CurrentExecutionFilePath property.
    //private $CurrentExecutionFilePathExtension = null;
	
	//Gets the virtual path of the current request.
    //private $FilePath	= null;
	
    //Gets the collection of files uploaded by the client, in multipart MIME format.
    //private $Files = null;

	//Gets or sets the filter to use when reading the current input stream.
    //private $Filter = null;

	//Gets a collection of form variables.
    //private $Form = null;

	//Gets a collection of HTTP headers.
    private $Headers = null;
    public function getHeaders() {
    	if (empty($this->Headers)) {
    		if (is_callable('apache_request_headers')) {
    			$this->Headers = apache_request_headers();
    		}
    		if (empty($this->Headers) || 
    			(count($this->Headers)==0)) {
    			
    			$this->Headers = array();
    			foreach($_SERVER as $key => $value) {
    				if (substr($key, 0, 5) <> 'HTTP_') {
    					continue;
    				}
    				$header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
    				$this->Headers[$header] = $value;
    			}
    		}
    	}
    	return $this->Headers;
    }
    
	//Gets the ChannelBinding object of the current HttpWorkerRequest instance.
    //private $HttpChannelBinding = null;

	//Gets the HTTP data transfer method (such as GET, POST, or HEAD) used by the client.
	private $HttpMethod = null;
	public function getHttpMethod() {
		if (empty($this->HttpMethod)) {
			$this->HttpMethod = $_SERVER['REQUEST_METHOD'];
		}
		return $this->HttpMethod;
	}
	
	//Gets the contents of the incoming HTTP entity body.
	//private $InputStream = null;
	
	//Gets a value indicating whether the request has been authenticated.
	//private $IsAuthenticated = null;
	
	//Gets a value indicating whether the request is from the local computer.
	private $IsLocal = null;
	public function getIsLocal() {
		if (empty($this->IsLocal)) {
			$whitelist = array( '127.0.0.1', '::1' );
			$this->IsLocal = (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) ? true : false;
		}
		return $this->IsLocal;
	}
		
	//Gets a value indicating whether the HTTP connection uses secure sockets (that is, HTTPS).
	private $IsSecureConnection = null;
	public function getIsSecureConnection() {
		if (empty($this->IsSecureConnection)) {
			$this->IsSecureConnection = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') ? true : false;
		}
		return $this->IsSecureConnection;
	}


	//Gets the specified object from the QueryString, Form, Cookies, or ServerVariables collections.
	//private $Item = null;
	
	//Gets the WindowsIdentity type for the current user.
	//private $LogonUserIdentity = null;	
		
	//Gets a combined collection of QueryString, Form, Cookies, and ServerVariables items.
	//private $Params = null;
		
	//Gets the virtual path of the current request.
	//private $Path = null;
	
	//Gets additional path information for a resource with a URL extension.
	//private $PathInfo = null;
		
	//Gets the physical file system path of the currently executing server application's root directory.
	//private $PhysicalApplicationPath = null;
    	
    //Gets the physical file system path corresponding to the requested URL.
	//private $PhysicalPath = null;
    	
    //Gets the collection of HTTP query string variables.
    private $QueryString = null;
    public function getQueryString() {
    	if (empty($this->QueryString)) {
    		$this->QueryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
    	}
    	return $this->QueryString;
    }
    
    //Gets the raw URL of the current request.
    //private $RawUrl = null;
    
    //Gets a value that indicates whether the request entity body has been read, and if so, how it was read.
    //private $ReadEntityBodyMode = null;
    
    //Gets the RequestContext instance of the current request.
    //private $RequestContext = null;
    
    //Gets or sets the HTTP data transfer method (GET or POST) used by the client.
    //private $RequestType = null;
    
    //Gets a collection of Web server variables.
    //private $ServerVariables = null;
    
    //Gets a CancellationToken object that is tripped when a request times out.
    //private $TimedOutToken = null;
    
    //Gets the number of bytes in the current input stream.
    //private $TotalBytes = null;
    
    //Provides access to HTTP request values without triggering request validation.
    //private $Unvalidated = null;
    
    //Gets information about the URL of the current request.
    private $Url = null;
    public function getUrl() {
    	if (empty($this->Url)) {
    		$this->Url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
    	}
    	return $this->Url;
    }
    //Gets information about the URL of the client's previous request that linked to the current URL.
	private $UrlReferrer = null;
	public function getUrlReferrer() {
		if (empty($this->UrlReferrer)) {
			$this->UrlReferrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
		}
		return $this->UrlReferrer;
	}
	
    //Gets the raw user agent string of the client browser.
    private $UserAgent = null;
    public function getUserAgent() {
    	if (empty($this->UserAgent)) {
    		$this->UserAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
    	}
    	return $this->UserAgent;
    }

    //Gets the IP host address of the remote client.
    private $UserHostAddress = null;
    public function getUserHostAddress() {
    	if (empty($this->UserHostAddress)) {
    		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    			$this->UserHostAddress = trim(current(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])));
    		} elseif (isset($_SERVER['HTTP_CLIENTIP']) && !empty($_SERVER['HTTP_CLIENTIP'])) {
    			$this->UserHostAddress = trim($_SERVER['HTTP_CLIENTIP']);
    		} elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
    			$this->UserHostAddress = trim($_SERVER['REMOTE_ADDR']);
			} 
		}
		return $this->UserHostAddress;
    }
    
    
    //Gets the DNS name of the remote client.
    //private $UserHostName = null;
    
    //Gets a sorted string array of client language preferences.
    private $UserLanguages = null;
    public function getUserLanguages() {
	    if (empty($this->lUserLanguages)) {
	    	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) &&
	    	preg_match_all("/([a-zA-Z-]+)(?:;q=([0-9.]+))?/i", $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches)) {
	    		foreach ($matches[2] as $k => $v) {
	    			if (empty($v)) {
	    				$matches[2][$k] = 1;
	    			}
	    		}
	    		$this->UserLanguages = array_combine($matches[1], $matches[2]);
	    		arsort($this->UserLanguages);
	    	} else {
	    		$this->UserLanguages = array('zh-TW' => 1);
	    	}
	    }
	    return $this->UserLanguages;
    }
}