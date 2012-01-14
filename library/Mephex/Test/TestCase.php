<?php



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
	 * Lazy-loaded database connection factory.
	 * 
	 * @var Mephex_Db_Sql_ConnectionFactory
	 */
	protected $_connection_factory	= null;
	
	/**
	 * Lazy-loaded database connections, indexed by config group key and
	 * database connection name.
	 * 
	 * @var array
	 */
	protected $_connections			= array();
	
	
	/**
	 * Lazy-loaded temporary file copier.
	 * 
	 * @var Mephex_Test_TmpFileCopier
	 */
	protected $_copier;
	
	/**
	 * Option set for organizing configuration options
	 * 
	 * @var Mephex_Config_OptionSet
	 */
	protected $_config;
	
	
	
	/**
	 * Deallocates any resources created by a test case.
	 */
	protected function tearDown()
	{
		$this->_connection_factory	= null;
		$this->_connections			= array();
		
		$this->_copier		= null;
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
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	protected function getSqliteCredential($db_name)
	{
		return new Mephex_Db_Sql_Pdo_CredentialDetails("sqlite:{$db_name}");
	}
	
	
	
	/**
	 * Generates a PDO connection using the given credentials.
	 * 
	 * @param Mephex_Db_Sql_Pdo_CredentialDetails $write_db - the database credential
	 * 		for the write connection
	 * @param Mephex_Db_Sql_Pdo_CredentialDetails $read_db - the database credential
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
		
		return new Mephex_Db_Sql_Pdo_Connection(
			new Mephex_Db_Sql_Base_Quoter_Sqlite(),
			$write_credential,
			$read_credential
		);
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
	
	
	
	/**
	 * Lazy-loads a connection factory.
	 * 
	 * @return Mephex_Db_Sql_ConnectionFactory
	 */
	protected function getDbConnectionFactory()
	{
		if(null === $this->_connection_factory)
		{
			$this->_connection_factory	= new Mephex_Test_Db_ConnectionFactory($this->getTmpCopier());
		}
		
		return $this->_connection_factory;
	}
	
	
	
	/**
	 * Lazy-loads a database connection that is specified by the configuration
	 * settings in the given group with the given connection name.
	 * 
	 * @param string $conn_name - the connection name
	 * @param string $group - the config group name
	 * @return Mephex_Db_Sql_Base_Connection
	 */
	protected function getDbConnection($conn_name, $group = 'database')
	{
		if(!isset($this->_connections[$group][$conn_name]))
		{
			$this->_connections[$group][$conn_name] =
				$this->getDbConnectionFactory()->connectUsingConfig
				(
					$this->getConfig(),
					$group,
					$conn_name
				);
		}
		
		return $this->_connections[$group][$conn_name];
	} 
	
	
	
	/**
	 * Loads a PHPUnit XML data set into a database.
	 * 
	 * @param Mephex_Db_Sql_Pdo_Connection $conn - the connection to use
	 * 		when inserting the data
	 * @param string $class - the name of the class that is being tested
	 * @param string $set_name - the test set name
	 * @return bool
	 */
	protected function loadXmlDataSetIntoDb(
		Mephex_Db_Sql_Pdo_Connection $conn, $class, $set_name
	)
	{
		$importer	= new Mephex_Db_Importer_PhpUnit_XmlDataSet($conn);
		$file		= str_replace('_', DIRECTORY_SEPARATOR, $class . '_dbs_') . $set_name . '.xml';
		return $importer->import($file);
	}
	
	
	
	/**
	 * Lazy-loads the config option set.
	 * 
	 * @return Mephex_Config_OptionSet
	 */
	protected function getConfig()
	{
		if(null === $this->_config)
		{
			$this->_config	= new Mephex_Config_OptionSet();
			foreach($this->getConfigLoaders() as $loader)
			{
				$this->_config->addLoader($loader);
			}
		}
		
		return $this->_config;
	}
	
	
	
	/**
	 * Returns an array of config loaders for the config
	 * option set to use.
	 * 
	 * @return array
	 */
	protected function getConfigLoaders()
	{
		return array(
			new Mephex_Config_Loader_Ini(
				PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'config.ini'
			)
		);
	}
}  