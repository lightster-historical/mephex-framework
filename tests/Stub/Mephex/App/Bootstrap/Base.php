<?php



class Stub_Mephex_App_Bootstrap_Base
extends Mephex_App_Bootstrap_Base
{
	private $_action_ctrl_name;
	private $_action_name;

	private $_is_inited	= false;



	public function __construct(array $args)
	{
		$this->_action_ctrl_name	= $args['action_ctrl_name'];
		$this->_action_name			= $args['action_name'];

		parent::__construct($args);
	}



	protected function init()
	{
		parent::init();
		
		$this->_is_inited	= true;
	}



	public function isInited()
	{
		return $this->_is_inited;
	}


	
	protected function addDefaultClassLoaders(Mephex_App_AutoLoader $auto_loader)
	{
		parent::addDefaultClassLoaders($auto_loader);
		$auto_loader->addClassLoader(
			new Mephex_App_ClassLoader_PathOriented(
				'Stub_Mephex_App_Bootstrap_Base_PrefixA'
			)
		);
		$auto_loader->addClassLoader(
			new Mephex_App_ClassLoader_PathOriented(
				'Stub_Mephex_Controller_'
			)
		);
	}



	protected function generateFrontController()
	{
		return new Stub_Mephex_Controller_Front_Base(
			$this->_action_ctrl_name,
			$this->_action_name
		);
	}



	public function getArguments()
		{return parent::getArguments();}
	public function getFrontController()
		{return parent::getFrontController();}
}