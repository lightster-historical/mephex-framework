<?php



/**
 * Loads resources based on resource names.
 * 
 * @author mlight
 */
interface Mephex_App_Resource_Loader
{
	/**
	 * Returns the name of the class that all resources from this loader
	 * will implement/extend.
	 *
	 * @return string
	 */
	public function getClassName();

	/**
	 * Loads the resource with the given resource name.
	 *
	 * @param string $resource_name - the name of the resource to load
	 * @return object
	 */
	public function loadResource($resource_name);
}