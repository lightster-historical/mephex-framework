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
		$value	= $this->get('HTTP_X_REQUESTED_WITH', null);

		return (null === $value) ?	null :
									(strtolower($value) === 'xmlhttprequest');
	}
	
	
	
	/**
	 * Checks to see if the request is a no-cache request (e.g. the page
	 * was 'hard-refreshed').
	 * 
	 * @return bool
	 */
	public function isNoCacheRequest()
	{
		$value	= $this->get('HTTP_CACHE_CONTROL', null);

		return (null === $value) ?	null :
									(bool)preg_match('/no-cache/i', (string)$value);
	}
}