<?php



/**
 * Generates a testing credential for a given DBMS using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Test_Db_Sql_Pdo_CredentialFactory
extends Mephex_Db_Sql_Pdo_CredentialFactory
{
	/**
	 * Generates a list of possible DBMS class names based on the DBMS name.
	 * 
	 * @param string $dbms - the DBMS name (e.g. mysql or sqlite)
	 * @return array
	 */
	protected function getDbmsClassNames($dbms)
	{ 
		$classes	= parent::getDbmsClassNames($dbms);
		array_unshift($classes, "Mephex_Test_Db_Sql_Pdo_CredentialFactory_{$dbms}");
		
		return $classes;
	}
}