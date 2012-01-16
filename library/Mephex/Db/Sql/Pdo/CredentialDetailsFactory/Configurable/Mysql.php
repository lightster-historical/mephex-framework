<?php



/**
 * Generates credential details for a MySQL connection using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql
extends Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable
{
	/**
	 * Get the credential details with the given name.
	 *
	 * @param string $name - the name of the credential/connection
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 * @see Mephex_Db_Sql_Pdo_CredentialDetailsFactory#getCredentialDetails
	 */
	public function getCredentialDetails($name)
	{
		$username	= $this->_config->get($this->_group, "{$name}.username", null, false);
		$password	= $this->_config->get($this->_group, "{$name}.password", null, false);
		$database	= $this->_config->get($this->_group, "{$name}.database");
		
		$host		= null;
		$port		= null;
		$socket		= null;
		
		try
		{
			$host	= $this->_config->get($this->_group, "{$name}.host");
			$port	= $this->_config->get($this->_group, "{$name}.port", null, false);
		}
		catch(Mephex_Config_OptionSet_Exception_UnknownKey $ex)
		{
			try
			{
				$socket	= $this->_config->get($this->_group, "{$name}.socket");
			}
			catch(Mephex_Config_OptionSet_Exception_UnknownKey $second_ex)
			{
				throw $ex;
			}
		}
		
		$parts	= array();
		
		if($host)
		{
			$parts[]	= "host={$host}";
			if($port)
			{
				$parts[]	= "port={$port}";
			}
		}
		else if($socket)
		{
			$parts[]	= "unix_socket={$socket}";
		}
		
		$parts[]	= "dbname={$database}";
		
		return new Mephex_Db_Sql_Pdo_CredentialDetails(
			'mysql:' . implode(';', $parts), 
			$username,
			$password
		);
	}



	/**
	 * Generates the quoter for the given credential/connection name.
	 *
	 * @param string $name - the name of the credential/connection to generate
	 *		the quoter for
	 * @return Mephex_Db_Sql_Quoter
	 * @see Mephex_Db_Sql_Pdo_CredentialDetailsFactory#getQuoter
	 */
	public function getQuoter($name)
	{
		return new Mephex_Db_Sql_Base_Quoter_Mysql();
	}
}