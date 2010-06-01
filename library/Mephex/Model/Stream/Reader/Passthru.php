<?php



/**
 * Reader stream that retrieves its raw record from the given 
 * Mephex_Model_Criteria_StreamReader.
 * 
 * @author mlight
 */
class Mephex_Model_Stream_Reader_Passthru
extends Mephex_Model_Stream_Reader
{
	/**
	 * Reads the records that meet the specified criteria
	 * from the storage system.
	 * 
	 * @param array $criteria
	 * @return Iterator - an iterator used to 
	 */
	public function read(Mephex_Model_Criteria $criteria)
	{
		if(!($criteria instanceof Mephex_Model_Criteria_StreamReader))
		{
			throw new Mephex_Model_Stream_Exception_UnexpectedCriteriaType(
				$this, $criteria, 'Mephex_Model_Criteria_StreamReader'
			);
		}
		
		$array	= new ArrayObject(array($criteria->getStreamReaderData()));
		return $array->getIterator();
	}
}  