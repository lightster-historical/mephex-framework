<?php



class Stub_Mephex_Controller_Action_Http
extends Mephex_Controller_Action_Http
{
	public function getHttpConnectionInfo() 
		{return parent::getHttpConnectionInfo();}
	public function getPostRequest()
		{return parent::getPostRequest();}
	public function getGetRequest()
		{return parent::getGetRequest();}
	public function checkArguments(Mephex_App_Arguments $args)
		{return parent::checkArguments($args);}
	public function getExpectedArgumentsClass()
		{return parent::getExpectedArgumentsClass();}
}