<?php



/**
 * Exception thrown when an unknown quoter type is used when creating 
 * credential details.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_Exception_UnknownQuoter
extends Mephex_Exception
{
	/**
	 * The credential detials factory that was trying to find a quoter.
	 * 
	 * @var Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable
	 */
	protected $_details_factory;
	
	/**
	 * The quoter name that was provided.
	 * 
	 * @var string
	 */
	protected $_quoter_name;
	
	/**
	 * The array of classes that were searched for.
	 * 
	 * @var array
	 */
	protected $_classes;
	
	
	
	/**
	 * @param Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable 
	 *		$details_factory - the credential details factory that was trying
	 *		to find the quoter
	 * @param string $quoter_name - the quoter name that was provided
	 * @param string $classes - the array of classes that were searched for
	 */
	public function __construct(
		Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable $details_factory,
		$quoter_name,
		array $classes
	)
	{
		parent::__construct(
			"Quoter '{$quoter_name}' not found (using classes: '"
			. implode("','", $classes)
			. "')."
		);
		
		$this->_details_factory		= $details_factory;
		$this->_quoter_name			= $quoter_name;
		$this->_classes				= $classes;
	}
	
	
	
	/**
	 * Getter for credential details factory.
	 * 
	 * @return Mephex_Db_Sql_Pdo_CredentialFactory_Configurable
	 */
	public function getCredentialDetailsFactory()
	{
		return $this->_details_factory;
	}
	
	
	
	/**
	 * Getter for quoter name.
	 * 
	 * @return string
	 */
	public function getQuoterName()
	{
		return $this->_quoter_name;
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