<?php



class Stub_Mephex_Db_Sql_ConnectionFactory
extends Mephex_Db_Sql_ConnectionFactory
{
	protected $_connections;



	public function __construct(array $connections)
	{
		$this->_connections	= $connections;
	}
	
	
	
	public function connectUsingConfig(
		Mephex_Config_OptionSet $config, $group, $connection_name
	)
	{
		return $this->_connections[$connection_name];
	}
}