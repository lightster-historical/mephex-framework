<?php



class Stub_Mephex_App_Action_Controller_Http
extends Mephex_App_Action_Controller_Http
{
	public function getHttpConnectionInfo() 
		{return parent::getHttpConnectionInfo();}
	public function getPostRequest()
		{return parent::getPostRequest();}
	public function getGetRequest()
		{return parent::getGetRequest();}
}