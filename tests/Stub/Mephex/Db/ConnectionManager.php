<?php



class Stub_Mephex_Db_ConnectionManager
extends Mephex_Db_ConnectionManager
{
	private $_connections_to_lazy_load;
	private $_generated_count	= array();



	public function __construct($connections_to_lazy_load)
	{
		$this->_connections_to_lazy_load	= $connections_to_lazy_load;
	}



	public function generateConnection($name)
	{
		if(!array_key_exists($name, $this->_generated_count))
		{
			$this->_generated_count[$name]	= 0;
		}

		$this->_generated_count[$name]++;
		return $this->_connections_to_lazy_load[$name];
	}



	public function getGeneratedCount($name)
	{
		return $this->_generated_count[$name];
	}
}