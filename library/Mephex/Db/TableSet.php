<?php



/**
 * Represents a set of table names, possibly prefixed and/or suffixed.
 * 
 * @author mlight
 */
class Mephex_Db_TableSet
{
	/**
	 * A prefix to prepend to a table name.
	 * 
	 * @var string
	 */
	protected $_prefix	= '';
	
	/**
	 * A suffix to append to a table name.
	 * @var unknown_type
	 */
	protected $_suffix	= '';
	
	/**
	 * A list of declared (implicitly or otherwise) table names.
	 * 
	 * @var array
	 */
	protected $_tables	= array();
	
	
	
	/**
	 * @param string $prefix - a prefix to prepend to a table name
	 * @param string $suffix - a suffix to append to a table name
	 */
	public function __construct($prefix = '', $suffix = '')
	{
		$this->setPrefix($prefix);
		$this->setSuffix($suffix);
	}
	
	
	
	/**
	 * Sets the table prefix.
	 * 
	 * @param string $prefix
	 * @return void
	 */
	public function setPrefix($prefix)
	{
		$this->_prefix	= $prefix;
	}
	
	
	
	/**
	 * Getter for prefix.
	 * 
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->_prefix;
	}
	
	
	
	/**
	 * Sets the table suffix.
	 * 
	 * @param string $suffix
	 * @return void
	 */
	public function setSuffix($postfix)
	{
		$this->_suffix	= $postfix;
	}
	
	
	
	/**
	 * Getter for suffix.
	 * 
	 * @return string
	 */
	public function getSuffix()
	{
		return $this->_suffix;
	}
	
	
	
	/**
	 * Getter for a tablename.
	 * 
	 * @param string $key
	 * @return string
	 */
	public function get($key)
	{
		if(!isset($this->_tables[$key]))
		{
			$this->_tables[$key] = 
				$this->_prefix . $key . $this->_suffix;
		}
		
		return $this->_tables[$key];
	}
	
	
	
	/**
	 * Setter for table name.
	 * 
	 * @param string $key - the table alias 
	 * @param string $tablename - the actual table name
	 */
	public function set($key, $tablename)
	{
		$this->_tables[$key]	= $tablename;
	}
}