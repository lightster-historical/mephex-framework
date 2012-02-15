<?php



/**
 * Abstract class for bootstrapping an application.
 * 
 * @author mlight
 */
abstract class Mephex_App_Bootstrap
{
	/**
	 * Runs the application.
	 *
	 * @param Mephex_App_Resource_List $resource_list
	 * @return Mephex_Controller_Front
	 */
	public abstract function run(Mephex_App_Resource_List $resource_list); 
}