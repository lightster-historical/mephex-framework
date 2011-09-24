<?php



/**
 * Controller for determining and running the action in the action controller.
 * 
 * @author mlight
 */
abstract class Mephex_Controller_Front_Base
implements Mephex_Controller_Front
{
	/**
	 * The lazy-loaded router.
	 *
	 * @var Mephex_Controller_Router
	 */
	protected $_router	= null;


	/**
	 * The lazy-loaded action controller.
	 *
	 * @var Mephex_Controller_Action_Base
	 */
	protected $_action_controller	= null;



	public function __construct()
	{
	}
	
	
	
	/**
	 * Runs the application.
	 *
	 * @Return void
	 */
	public function run()
	{
		$router	= $this->getRouter();
		
		return $this->runAction(
			$this->getActionController(),
			$this->getRouter()->getActionName()
		);
	}
	
	

	/**
	 * The router to use for determining the action controller and action
	 * name to run.
	 *
	 * @return Mephex_Controller_Router
	 */	
	protected abstract function generateRouter();



	/**
	 * Lazy-loading getter for the router.
	 *
	 * @return Mephex_Controller_Router
	 */
	protected function getRouter()
	{
		if(null === $this->_router)
		{
			$this->_router	= $this->checkObjectInheritance(
				$this->generateRouter(),
				'Mephex_Controller_Router',
				true
			);
		}

		return $this->_router;
	}
	
	
	
	/**
	 * Generate an instance of the action controller specified by the
	 * given class name.
	 * 
	 * @param string $class_name - the action controller space name
	 * @return Mephex_Controller_Action_Base
	 */
	protected function generateActionController($class_name)
	{
		return new $class_name($this);
	}
	
	
	
	/**
	 * Lazy-loading getter for the action controller.
	 *
	 * @return Mephex_Controller_Action_Base
	 */
	protected function getActionController()
	{
		if(null === $this->_action_controller)
		{
			$expected_class	= 'Mephex_Controller_Action_Base';
			$class_name	= $this->checkClassInheritance(
				$this->getRouter()->getClassName(),
				$expected_class
			);
			$this->_action_controller	= $this->checkObjectInheritance(
				$this->generateActionController($class_name),
				$expected_class
			);
		}

		return $this->_action_controller;
	}
	
	
	
	/**
	 * Runs the specified action in the action controller.
	 *
	 * @param Mephex_Controller_Action $action_controller - the action
	 *		controller to use
	 * @param string $action_name - the action name to run
	 * @return void
	 */
	protected function runAction(
		Mephex_Controller_Action $action_controller,
		$action_name
	)
	{
		return $action_controller->runAction($action_name);
	}



	/**
	 * Checks to see if a given object is an instance of class that
	 * extends/implements another class/interface, returning the original object
	 * upon success and throwing an exception otherwise.
	 *
	 * @param object $object - the object to check
	 * @param string $expected - the class the passed class is expected to
	 *		to extend/implement
	 * @return string - the passed class on success
	 * @throws Mephex_Controller_Front_Exception_NonexistentClass
	 * @throws Mephex_Controller_Front_Exception_ExpectedObject
	 */
	protected function checkObjectInheritance($object, $expected)
	{
		if(!is_object($object))
		{
			throw new Mephex_Controller_Front_Exception_ExpectedObject(
				$expected, $object
			);
		}
		else if(!is_object($expected) 
			&& !class_exists($expected)
			&& !interface_exists($expected)
		)
		{
			throw new Mephex_Controller_Front_Exception_NonexistentClass($expected);
		}
		else if(!($object instanceof $expected))
		{
			throw new Mephex_Controller_Front_Exception_ExpectedObject(
				$expected, $object
			);
		}

		return $object;
	}



	/**
	 * Checks to see if a given class extends/implements another 
	 * class/interface, returning the original class upon success and throwing
	 * an exception otherwise.
	 *
	 * @param string $class - the class to check
	 * @param string $expected - the class the passed class is expected to
	 *		to extend/implement
	 * @return string - the passed class on success
	 * @throws Mephex_Controller_Front_Exception_NonexistentClass
	 * @throws Mephex_Controller_Front_Exception_UnexpectedClass
	 */
	protected function checkClassInheritance($class, $expected)
	{
		if(!is_object($expected) 
			&& !class_exists($expected)
			&& !interface_exists($expected)
		)
		{
			throw new Mephex_Controller_Front_Exception_NonexistentClass($expected);
		}
		else if(!class_exists($class))
		{
			throw new Mephex_Controller_Front_Exception_NonexistentClass($class);
		}

		$reflection		= new ReflectionClass($class);
		$is_child		= (interface_exists($expected)
			? $reflection->implementsInterface($expected)
			: $reflection->isSubclassOf($expected)
		);
		if(!$is_child)
		{
			throw new Mephex_Controller_Front_Exception_UnexpectedClass(
				$expected, $class
			);
		}

		return $class;
	}
}