<?php



/**
 * Controller for grouping similar HTTP actions/processes.
 * 
 * @author mlight
 */
abstract class Mephex_Controller_Action_Http
extends Mephex_Controller_Action_Base
{
	/**
	 * The HTTP connection info.
	 *  
	 * @var Mephex_App_Arguments_HttpConnection
	 */
	private $_http_connection;
	
	/**
	 * Arguments passed via POST arguments.
	 * 
	 * @var Mephex_App_Arguments
	 */
	private $_request_post;
	
	/**
	 * Arguments passed via GET arguments.
	 * 
	 * @var Mephex_App_Arguments
	 */
	private $_request_get;
	
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_http_connection	= new Mephex_App_Arguments_HttpConnection($_SERVER);
		$this->_request_post	= new Mephex_App_Arguments($_POST);
		$this->_request_get		= new Mephex_App_Arguments($_GET);
	}
	
	
	
	/**
	 * Getter for HTTP connection info.
	 * 
	 * @return Mephex_App_Arguments_HttpConnection
	 */
	protected function getHttpConnectionInfo()
	{
		return $this->_http_connection;
	}
	
	
	
	/**
	 * Getter for POST request arguments.
	 * 
	 * @return Mephex_App_Arguments
	 */
	protected function getPostRequest()
	{
		return $this->_request_post;
	}
	
	
	
	/**
	 * Getter for GET request arguments.
	 * 
	 * @return Mephex_App_Arguments
	 */
	protected function getGetRequest()
	{
		return $this->_request_get;
	}
}