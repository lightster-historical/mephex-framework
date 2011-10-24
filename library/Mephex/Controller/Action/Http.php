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



	/**
	 * Checks the arguments object to make sure it extends the expected class.
	 *
	 * @param Mephex_App_Arguments $args - the arguments object to check
	 *		the class type of
	 * @return void
	 * @see Mephex_Controller_Action_Http#checkArguments
	 */
	protected function checkArguments(Mephex_App_Arguments $arguments)
	{
		parent::checkArguments($arguments);

		$this->_http_connection	= $arguments->getHttpConnectionInfo();
		$this->_request_post	= $arguments->getPostRequest();
		$this->_request_get		= $arguments->getGetRequest();
	}



	/**
	 * Getter for the expected arguments class name.
	 *
	 * @return string
	 * @see Mephex_Controller_Action_Http#getExpectedArgumentsClass
	 */
	protected function getExpectedArgumentsClass()
	{
		return 'Mephex_App_Arguments_Http';
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