<?php



/**
 * Controller for grouping similar actions/processes.
 * 
 * @author mlight
 */
interface Mephex_Controller_Action
{
	/**
	 * Runs the given action and the pre/post action processes.
	 * 
	 * @param string $action_name - the action that is being requested
	 * @return void
	 */
	public function runAction($action_name);
}