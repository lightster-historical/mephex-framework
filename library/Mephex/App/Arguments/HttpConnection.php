<?php



/**
 * Provides information related to the connection to the server through HTTP.
 * 
 * @author mlight
 */
class Mephex_App_Arguments_HttpConnection
extends Mephex_App_Arguments
{
	/**
	 * @param array $args - a list of argument values to start off with
	 */
	public function __construct(array $arguments)
	{
		parent::__construct($arguments);
	}
	
	
	
	/**
	 * Checks to see if the request is an XmlHttp/AJAX request.
	 * 
	 * @return bool
	 */
	public function isXmlHttpRequest()
	{
		return strtolower($this->get('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest';
	}
	
	
	
	/**
	 * Checks to see if the request is a no-cache request (e.g. the page
	 * was 'hard-refreshed').
	 * 
	 * @return bool
	 */
	public function isNoCacheRequest()
	{
		return (bool)preg_match('/no-cache/', (string)$this->get('HTTP_CACHE_CONTROL'));
	}
}