<?php



/**
 * The class and file name do not match as the auto-loader
 * would expect, so we must load it manually
 */
require_once 'PHPUnit/Framework.php';


 
/**
 * 
 * NOTE: we declare the class abstract so that PHPUnit will not 
 * try to run the class as its own independent unit test case.
 * Only (non-abstract) sub classes will be ran as unit tests.
 * 
 * @author mlight
 */
abstract class Mephex_Test_TestCase
extends PHPUnit_Framework_TestCase
{
	/**
	 * Lazy-loaded temporary file copier.
	 * 
	 * @var Mephex_Test_TmpFileCopier
	 */
	protected $_copier;
	
	
	
	/**
	 * Deallocates any resources created by a test case.
	 */
	protected function tearDown()
	{
		$this->_copier	= null;
	} 
	
	
	
	/**
	 * Lazy-loads the temporary file copier.
	 * 
	 * @param string $dir - the directory to use to store the temporary files
	 * @return Mephex_Test_TmpFileCopier
	 */
	public function getTmpCopier($dir = 'tmp')
	{
		if(null === $this->_copier)
		{ 
			$this->_copier = new Mephex_Test_TmpFileCopier(PATH_TEST_ROOT . DIRECTORY_SEPARATOR . $dir);
		}
		
		return $this->_copier;
	}
	
	
	
	/**
	 * Generates a database credential for the given sqlite3 database.
	 * 
	 * @param string $db_name - the name of the database file
	 * @return Mephex_Db_Sql_Pdo_Credential
	 */
	protected function getSqliteCredential($db_name)
	{
		return new Mephex_Db_Sql_Pdo_Credential("sqlite:{$db_name}");
	}
	
	
	
	/**
	 * Generates a PDO connection using the given credentials.
	 * 
	 * @param Mephex_Db_Sql_Pdo_Credential $write_db - the database credential
	 * 		for the write connection
	 * @param Mephex_Db_Sql_Pdo_Credential $read_db - the database credential
	 * 		for the read connection; if not provided, the write connection is 
	 * 		used for reading as well
	 * @return Mephex_Db_Sql_Pdo_Connection
	 */
	protected function getSqliteConnection($write_db, $read_db = null)
	{
		$write_db	= $this->getTmpCopier()->copy($write_db);
		$read_db	= ($read_db ? $this->getTmpCopier()->copy($read_db) : null);
		
		$write_credential	= $this->getSqliteCredential($write_db);
		$read_credential	= ($read_db ? $this->getSqliteCredential($read_db) : null);
		
		return new Mephex_Db_Sql_Pdo_Connection($write_credential, $read_credential);
	}
	
	
	
	/**
	 * Generates the path to a sqlite database.
	 * 
	 * @param string $class - the class that the database came with
	 * @param string $database - the name of the database file
	 * @return string
	 */
	protected function getSqliteDatabase($class, $database)
	{
		return str_replace('_', DIRECTORY_SEPARATOR, $class . '_dbs_') . $database . '.sqlite3';
	}
}  