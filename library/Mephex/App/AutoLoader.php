<?php



/**
 * Used for loading not-yet-loaded classes as they are required.
 * 
 * @author mlight
 */
class Mephex_App_AutoLoader
{
	/**
	 * Singleton instance of the object. (Normally only one instance is needed.)
	 * 
	 * @var Mephex_App_AutoLoader
	 */
	protected static $_instance	= null;
	
	
	/**
	 * Whether or not the auto-loader has been registered with SPL 
	 * (through this class).
	 * 
	 * @var bool
	 */
	protected $_spl_registered	= false;
	
	/**
	 * The list of class loaders to use when attempting to load a class.
	 * 
	 * @var array
	 */
	protected $_class_loaders	= array();
	
	
	
	public function __construct()
	{
	}
	
	
	
	/**
	 * Creates a singleton instance of this class (if necessary) 
	 * and returns the instance.
	 * 
	 * @return Mephex_App_AutoLoader
	 */
	public function getInstance()
	{
		if(self::$_instance === null)
		{
			self::$_instance	= new self();
		}
		
		return self::$_instance;
	}
	
	
	
	/**
	 * Adds a class loader to the auto loader.
	 * 
	 * @param Mephex_App_ClassLoader $class_loader
	 * @return void
	 */
	public function addClassLoader(Mephex_App_ClassLoader $class_loader)
	{
		$this->_class_loaders[]	= $class_loader;
	}
	
	
	
	/**
	 * Attempts to load the given class name.
	 * 
	 * @param string $class_name
	 * @return void
	 */
	public function loadClass($class_name)
	{
		foreach($this->_class_loaders as $class_loader)
		{
			if(class_exists($class_name, false))
			{
				break;
			}
			
			$class_loader->loadClass($class_name);
		}
	}
	
	
	
	/**
	 * Registers this auto-loader with SPL.
	 * 
	 * @return void
	 */
	public function registerSpl()
	{
		if(!$this->_spl_registered)
		{
			spl_autoload_register(array($this, 'loadClass'));
			$this->_spl_registered	= true;
		}
	}
	
	
	
	/**
	 * Unregisters this auto-loader with SPL.
	 * 
	 * @return void
	 */
	public function unregisterSpl()
	{
		if($this->_spl_registered)
		{
			spl_autoload_unregister(array($this, 'loadClass'));
			$this->_spl_registered	= false;
		}
	}
}