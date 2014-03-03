<?phpdefined('_PHPMVC2') or die;class Home extends Controller{	/**	 * PAGE: index	 * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)	 */
	public function index()	{		parent::View('home/index');	}
	public function test1($x="Test1")
	{
		parent::Content($x);
	}		public function test2()	{		global $app;		$app->loadSys('request');				$request = new Request();		parent::Content($request->getUserAgent());	}		public function test3()
	{
		global $app;
		$app->loadSys('request');
	
		$request = new Request();
	
		parent::Json($request->Headers);
	}}