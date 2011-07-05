<?php



class Stub_Mephex_Controller_Controller_Http
extends Mephex_Controller_Controller_Http
{
	public function getHttpConnectionInfo() 
		{return parent::getHttpConnectionInfo();}
	public function getPostRequest()
		{return parent::getPostRequest();}
	public function getGetRequest()
		{return parent::getGetRequest();}
}