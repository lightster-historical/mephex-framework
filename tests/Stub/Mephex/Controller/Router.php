<?php



class Stub_Mephex_Controller_Router
implements Mephex_Controller_Router
{
	protected $_front_ctrl;



	public function __construct(Mephex_Controller_Front $front_ctrl = null)
	{
		$this->_front_ctrl	= $front_ctrl;
	}



	public function getClassName()
	{
		if($this->_front_ctrl instanceof Stub_Mephex_Controller_Front_Base) {
			return $this->_front_ctrl->getActionControllerClassName();
		}
	}



	public function getActionName()
	{
		if($this->_front_ctrl instanceof Stub_Mephex_Controller_Front_Base) {
			return $this->_front_ctrl->getActionControllerActionName();
		}
	}
}