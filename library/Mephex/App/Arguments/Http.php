<?php



/**
 * Provides access to web server environment and request variables.
 * 
 * @author mlight
 */
class Mephex_App_Arguments_Http
extends Mephex_App_Arguments
{
	/**
	 * @param Mephex_App_Arguments_HttpConnection $http_info - 
	 *		HTTP connection/server info
	 * @param Mephex_App_Arguments $post_request - variables passed
	 *		by the POST method
	 * @param Mephex_App_Arguments $get_request - variables passed 
	 *		by the GET method
	 * @param array $args - an optional list of other argument values
	 */
	public function __construct(
		Mephex_App_Arguments_HttpConnection $http_info,
		Mephex_App_Arguments $post_request,
		Mephex_App_Arguments $get_request,
		array $arguments = null
	)
	{
		parent::__construct($arguments);

		$this->_http_info		= $http_info;
		$this->_request_post	= $post_request;
		$this->_request_get		= $get_request;
	}
	
	
	
	/**
	 * Getter for HTTP connection info.
	 * 
	 * @return Mephex_App_Arguments_HttpConnection
	 */
	public function getHttpConnectionInfo()
	{
		return $this->_http_info;
	}
	
	
	
	/**
	 * Getter for POST request arguments.
	 * 
	 * @return Mephex_App_Arguments
	 */
	public function getPostRequest()
	{
		return $this->_request_post;
	}
	
	
	
	/**
	 * Getter for GET request arguments.
	 * 
	 * @return Mephex_App_Arguments
	 */
	public function getGetRequest()
	{
		return $this->_request_get;
	}
}