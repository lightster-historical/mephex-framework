<?php



/**
 * Exception thrown when an unknown DBMS type is used when creating a credential.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_Exception_UnknownDbms
extends Mephex_Exception
{
	/**
	 * The credential factory that was trying to find a DBMS.
	 * 
	 * @var Mephex_Db_Sql_Pdo_CredentialFactory_Configurable
	 */
	protected $_credential_factory;
	
	/**
	 * The DBMS name that was provided.
	 * 
	 * @var string
	 */
	protected $_dbms;
	
	/**
	 * The array of classes that were searched for.
	 * 
	 * @var array
	 */
	protected $_classes;
	
	
	
	/**
	 * @param Mephex_Db_Sql_Pdo_CredentialFactory_Configurable $credential_factory
	 *		- the credential factory that was trying to find a DBMS
	 * @param string $dbms - the DBMS name that was provided
	 * @param string $classes - the array of classes that were searched for
	 */
	public function __construct(
		Mephex_Db_Sql_Pdo_CredentialFactory_Configurable $credential_factory,
		$dbms,
		array $classes
	)
	{
		parent::__construct(
			"DBMS '{$dbms}' not found (using classes: '"
			. implode("','", $classes)
			. "')."
		);
		
		$this->_credential_factory	= $credential_factory;
		$this->_dbms				= $dbms;
		$this->_classes				= $classes;
	}
	
	
	
	/**
	 * Getter for credential factory
	 * 
	 * @return Mephex_Db_Sql_Pdo_CredentialFactory_Configurable
	 */
	public function getCredentialFactory()
	{
		return $this->_credential_factory;
	}
	
	
	
	/**
	 * Getter for DBMS.
	 * 
	 * @return string
	 */
	public function getDbms()
	{
		return $this->_dbms;
	}
	
	
	
	/**
	 * Getter for classes.
	 * 
	 * @return array
	 */
	public function getClasses()
	{
		return $this->_classes;
	}
}