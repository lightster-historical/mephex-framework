<?php



/**
 * Criteria that holds a raw record from a reader stream.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Criteria_StreamReader 
extends Mephex_Model_Criteria
{
	/**
	 * Getter for the raw reader stream data.
	 * 
	 * @return mixed 
	 */
	public abstract function getStreamReaderData();
}