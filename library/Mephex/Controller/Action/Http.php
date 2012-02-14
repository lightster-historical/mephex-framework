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



	public function processPreAction()
	{
		parent::processPreAction();

		$resource_list			= $this->getResourceList();
		$resource_list->checkType('Arguments', 'Mephex_App_Arguments');
		$this->_http_connection	= $resource_list->checkResourceType(
			'Arguments',
			'HttpConnectionInfo',
			'Mephex_App_Arguments_HttpConnection'
		);
		$this->_request_post	= $resource_list->getResource(
			'Arguments',
			'PostRequest'
		);
		$this->_request_get		= $resource_list->getResource(
			'Arguments',
			'GetRequest'
		);
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