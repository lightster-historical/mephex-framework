<?php



/**
 * Generates a testing credential for a given DBMS using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Test_Db_Sql_Pdo_CredentialFactory_Configurable
extends Mephex_Db_Sql_Pdo_CredentialFactory_Configurable
{
	/**
	 * Generates a list of possible credential factory class names based for
	 * the DBMS name.
	 * 
	 * @param string $dbms - the DBMS name (e.g. mysql or sqlite)
	 * @return array
	 * @see Mephex_Db_Sql_Pdo_CredentialFactory_Configurable#getCredentialFactoryClassNames
	 */
	protected function getCredentialFactoryClassNames($dbms)
	{ 
		$classes	= parent::getCredentialFactoryClassNames($dbms);
		array_unshift($classes, "Mephex_Test_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_{$dbms}");
		
		return $classes;
	}
}