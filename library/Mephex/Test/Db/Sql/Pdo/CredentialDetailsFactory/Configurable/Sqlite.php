<?php



/**
 * Generates testing credential details for a Sqlite connection using a
 * config option set. 
 * 
 * @author mlight
 */
class Mephex_Test_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite
extends Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite
{
	/**
	 * Get the credential details with the given name.
	 *
	 * @param string $name - the name of the credential/connection
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 * @see Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite#getCredentialDetails
	 */
	public function getCredentialDetails($name)
	{
		if(!$this->_config->hasOption($this->_group, "{$name}.original_database"))
		{
			$src_database	= $this->_config->get($this->_group, "{$name}.database");
			$copier			= $this->_config->get($this->_group, "{$name}.tmp_copier");
			
			$database_copy	= $copier->copy($src_database);
			
			$this->_config->set($this->_group, "{$name}.database", $database_copy, true);
			$this->_config->set($this->_group, "{$name}.original_database", $src_database, true);
		}

		return parent::getCredentialDetails($name);
	}
}