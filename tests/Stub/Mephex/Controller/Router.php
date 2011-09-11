<?php



class Stub_Mephex_Controller_Router
implements Mephex_Controller_Router
{
	protected $_class_name;
	protected $_action_name;



	public function __construct($class_name, $action_name)
	{
		$this->_class_name	= $class_name;
		$this->_action_name	= $action_name;
	}



	public function getClassName()
	{
		return $this->_class_name;
	}



	public function getActionName()
	{
		return $this->_action_name;
	}
}