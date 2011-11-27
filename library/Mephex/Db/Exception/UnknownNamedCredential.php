<?php



/**
 * An exception thrown when a credential is requested by an unknown name 
 * 
 * @author mlight
 */
class Mephex_Db_Exception_UnknownNamedCredential
extends Mephex_Db_Exception
{
	/**
	 * The credential factory that the named credential was supposed to be in.
	 * 
	 * @var Mephex_Db_CredentialFactory
	 */
	protected $_credential_factory;
	
	/**
	 * The name of the credential that was being requested.
	 * 
	 * @var string
	 */
	protected $_credential_name;
	
	
	
	/**
	 * @param Mephex_Db_CredentialFactory $credential_factory -
	 *		the credential factory that was being used
	 * @param string $credential_name - the name of the credential that was
	 *		being requested
	 */
	public function __construct(
		Mephex_Db_CredentialFactory $credential_factory,
		$credential_name
	)
	{
		parent::__construct("A credential named '{$credential_name}' was not found in the credential factory.");
		
		$this->_credential_factory	= $credential_factory;
		$this->_credential_name		= $credential_name;
	}
	
	
	
	/**
	 * Getter for credential factory.
	 * 
	 * @return Mephex_Db_CredentialFactory
	 */
	public function getCredentialFactory()
	{
		return $this->_credential_factory;
	}
	
	
	
	/**
	 * Getter for credential name.
	 * 
	 * @return string
	 */
	public function getCredentialName()
	{
		return $this->_credential_name;
	}
}