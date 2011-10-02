<?php



class Stub_Mephex_Controller_Router_Front
implements Mephex_Controller_Router
{
	protected $_front_ctrl;



	public function __construct(Mephex_Controller_Front $front_ctrl)
	{
		$this->_front_ctrl	= $front_ctrl;
	}



	public function getClassName()
	{
		return $this->_front_ctrl->getActionControllerClassName();
	}



	public function getActionName()
	{
		return $this->_front_ctrl->getActionControllerActionName();
	}
}