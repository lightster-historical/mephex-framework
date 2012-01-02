<?php



/**
 * Dataset importer that imports a PHPUnit-style XML dataset
 * into a database.
 * 
 * @author mlight
 */
class Mephex_Db_Importer_PhpUnit_XmlDataSet
{
	/**
	 * Database connection.
	 * 
	 * @var Mephex_Db_Sql_Base_Connection
	 */
	protected $_connection	= null;
	
	
	/**
	 * A stack of XML tag names that are open
	 * (excluding the current/deepest open tag).
	 * 
	 * @var array
	 */
	protected $_open_tags	= array();
	
	/**
	 * The name of the currently opened tag that is open.
	 * 
	 * @var string
	 */
	protected $_curr_tag	= null;
	
	
	/**
	 * The database table that we are importing to.
	 * 
	 * @var string
	 */
	protected $_table		= null;
	
	/**
	 * The columns that we have data for.
	 * @var array
	 */
	protected $_columns		= null;
	
	/**
	 * A lazy-loaded query object.
	 * 
	 * @var Mephex_Db_Sql_Base_Query
	 */
	protected $_prepared	= null;
	
	
	/**
	 * An array of values to insert into the row.
	 * 
	 * @var array
	 */
	protected $_value_set	= null;
	
	/**
	 * Whether or not the currently open column has had
	 * a value provided. (If not, when the closing 'column'
	 * tag is reached, a n empty string is assumed.)
	 * 
	 * @var bool
	 */
	protected $_is_column_value_set	= false;
	
	
	/**
	 * An array of tag names translated to partial
	 * method names. (Due to PHP's case-insensitive methods,
	 * this array is technically optional.)
	 * 
	 * @var array
	 */
	protected $_tag_translation	= array(
		'dataset'		=> 'Dataset',
		'table'			=> 'Table',
		'column'		=> 'Column',
		'row'			=> 'Row',
		'value'			=> 'Value',
		'null'			=> 'Null'
	);
	
	/**
	 * An array of tags that are expected given the currently
	 * open tag.
	 * 
	 * @var array
	 */
	protected $_expected		= array(
		'dataset'	=> array(
			'table'		=> true
		),
		'table'		=> array(
			'column'	=> true,
			'row'		=> true
		),
		'row'		=> array(
			'value'		=> true,
			'null'		=> true
		)
	);
	
	
	
	/**
	 * @param Mephex_Db_Sql_Base_Connection $connection - the database
	 * 		the data should be inserted into.
	 */
	public function __construct(Mephex_Db_Sql_Base_Connection $connection)
	{
		$this->_connection	= $connection;
	}
	
	
	
	/**
	 * Imports the dataset in the XML file provided by the given file name.
	 *  
	 * @param string $file_name
	 * @return void
	 */
	public function import($file_name)
	{
		$parser	= xml_parser_create();

		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
		xml_set_character_data_handler($parser, array($this, 'processCdata'));
		xml_set_element_handler($parser, array($this, 'processElementBegin'), array($this, 'processElementEnd'));
		
		$file	= fopen($file_name, 'r');
		while(($contents = fgets($file, 1024)))
		{
			xml_parse($parser, $contents, false);
		}
		xml_parse($parser, '', true);
		fclose($file);
		
		xml_parser_free($parser);
	}
	
	
	
	/**
	 * Retrieves an array of tags that are expected (allowed)
	 * in the given parent tag.
	 * 
	 * @param string $parent_tag
	 * @return array
	 */
	protected function getExpectedTags($parent_tag)
	{
		if($this->_curr_tag === null)
		{
			return array('dataset' => true);
		}

		return $this->_expected[$this->_curr_tag];
	}
	
	
	
	/**
	 * Processes CDATA found in the XML file.
	 * 
	 * @param $parser - the XML parser
	 * @param string $data - the CDATA found
	 * @return void
	 */
	public function processCdata($parser, $data)
	{
		if($this->_curr_tag === 'column')
		{
			$data	= trim($data);
			$this->_columns[$data]	= $data;
		}
		else if($this->_curr_tag === 'value')
		{
			$key	= $this->getCurrentColumn();
			$this->_value_set[]			= $data;
			$this->_is_column_value_set	= true;
		}
		else if(trim($data) !== '')
		{
			throw new Mephex_Exception("Unexpected CDATA in '{$this->_curr_tag}' tag.");
		}
	}
	
	
	
	/**
	 * Processes the beginning of an element.
	 * 
	 * @param $parser - the XML parser
	 * @param string $tag - the name of the tag being opened
	 * @param array $attributes - the attributes provided with
	 * 		the opening tag
	 * @return void
	 */
	public function processElementBegin($parser, $tag, array $attributes)
	{
		$expected	= $this->getExpectedTags($this->_curr_tag);

		if(!isset($expected[$tag]))
		{
			throw new Mephex_Exception("Unexpected tag '{$tag}' in '{$this->_curr_tag}'.");
		}
		
		if($this->_curr_tag !== null)
		{
			$this->_open_tags[]	= $this->_curr_tag;
		}
		$this->_curr_tag	= $tag;
		$this->{'process' . $this->_tag_translation[$tag] . 'TagBegin'}($attributes);
	}
	
	
	
	/**
	 * Processes the end of an element.
	 * 
	 * @param $parser - the XML parser
	 * @param string $tag - the tag being closed
	 * @return void
	 */
	public function processElementEnd($parser, $tag)
	{
		$parent_tag	= array_pop($this->_open_tags);
		
		$this->{'process' . $this->_tag_translation[$tag] . 'TagEnd'}();
		
		$this->_curr_tag	= $parent_tag;
	}
	
	
	
	/**
	 * Processes the <dataset> tag.
	 * 
	 * @param array $attributes - the attributes provided with
	 * 		the opening tag
	 * @return void
	 */
	protected function processDatasetTagBegin(array $attributes)
	{
	}
	
	
	
	/**
	 * Processes the </dataset> tag.
	 * 
	 * @return void
	 */
	protected function processDatasetTagEnd()
	{
		
	}
	
	
	
	/**
	 * Processes the <table> tag.
	 * 
	 * @param array $attributes - the attributes provided with
	 * 		the opening tag
	 * @return void
	 */
	protected function processTableTagBegin(array $attributes)
	{
		if(!isset($attributes['name']))
		{
			throw new Mephex_Exception("Tag 'table' requires 'name' attribute.");
		}
		
		$this->_table	= $attributes['name'];
		$this->_columns	= array();
		
		$results	= $this->_connection->write("DELETE FROM {$this->_table}")->execute();
	}
	
	
	
	/**
	 * Processes the </table> tag.
	 * 
	 * @return void
	 */
	protected function processTableTagEnd()
	{
		$this->_table		= null;
		$this->_columns		= null;
		$this->_prepared	= null;
	}
	
	
	
	/**
	 * Processes the <column> tag.
	 * 
	 * @param array $attributes - the attributes provided with
	 * 		the opening tag
	 * @return void
	 */
	protected function processColumnTagBegin(array $attributes)
	{
	}
	
	
	
	/**
	 * Processes the </column> tag.
	 * 
	 * @return void
	 */
	protected function processColumnTagEnd()
	{
	}
	
	
	
	/**
	 * Processes the <row> tag.
	 * 
	 * @param array $attributes - the attributes provided with
	 * 		the opening tag
	 * @return void
	 */
	protected function processRowTagBegin(array $attributes)
	{
		$this->_value_set	= array();
		reset($this->_columns);
	}
	
	
	
	/**
	 * Processes the </row> tag.
	 * 
	 * @return void
	 */
	protected function processRowTagEnd()
	{
		if(count($this->_value_set) != count($this->_columns))
		{
			throw new Mephex_Exception('Value set does not contain a value for every column.');
		}

		$this->writeValueSet();
		$this->_value_set	= null;
	}
	
	
	
	/**
	 * Retrieves the column name for the currently open (or
	 * next to be opened) column.
	 */
	protected function getCurrentColumn()
	{
		$key	= key($this->_columns);
		
		if(null === $key)
		{
			throw new Mephex_Exception('Too many values provided for row set.');
		}
		
		return $key;
	}
	
	
	
	/**
	 * Processes the <value> tag.
	 * 
	 * @param array $attributes - the attributes provided with
	 * 		the opening tag
	 * @return void
	 */
	protected function processValueTagBegin(array $attributes)
	{
		$key	= $this->getCurrentColumn();
		$this->_is_column_value_set	= false;
	}
	
	
	
	/**
	 * Processes the </value> tag.
	 * 
	 * @return void
	 */
	protected function processValueTagEnd()
	{
		if(!$this->_is_column_value_set)
		{
			$this->_value_set[]	= '';	
		}
		
		next($this->_columns);
	}
	
	
	
	/**
	 * Processes the <null> tag.
	 * 
	 * @param array $attributes - the attributes provided with
	 * 		the opening tag
	 * @return void
	 */
	protected function processNullTagBegin(array $attributes)
	{
		$key	= $this->getCurrentColumn();
		$this->_value_set[]			= null;
		$this->_is_column_value_set	= true;
	}
	
	
	
	/**
	 * Processes the </null> tag.
	 * 
	 * @return void
	 */
	protected function processNullTagEnd()
	{
		next($this->_columns);
	}	
	
	
	
	/**
	 * Writes the current value set to the database.
	 * 
	 * @return void
	 */
	protected function writeValueSet()
	{
		if(!empty($this->_value_set))
		{
			if(null === $this->_prepared)
			{
				$insert		= new Mephex_Db_Sql_Base_Generator_Insert
				(
					$this->_connection->getQuoter(),
					$this->_table,
					$this->_columns
				);
				$this->_prepared	= $this->_connection->write
				(
					$insert->getSql(),
					Mephex_Db_Sql_Base_Query::PREPARE_NATIVE
				);
			}
			
			$this->_prepared->execute($this->_value_set);
		}
	}
}