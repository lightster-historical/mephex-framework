<?php



/**
 * Interface for determining action controller class name and action name.
 * 
 * @author mlight
 */
interface Mephex_Controller_Router
{
	/**
	 * Getter for class name of class extending Mephex_Controller_Action.
	 * 
	 * @return string
	 */
	public function getClassName();

	/**
	 * Getter for the name of the action to run.
	 *
	 * @return string
	 */
	public function getActionName();
}