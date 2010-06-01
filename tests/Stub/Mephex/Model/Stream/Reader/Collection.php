<?php



class Stub_Mephex_Model_Stream_Reader_Collection
extends Mephex_Model_Stream_Reader_Collection
{
	public function read(Mephex_Model_Criteria $criteria)
	{
		if($criteria->hasCriteriaFields($keys = array('Parent')))
		{
			$array	= new ArrayObject
			(
				array
				(
					array
					(
						'id'		=> 3,
						'parentId'	=> $criteria->getCriteriaValue('Parent')->getId()
					),
					array
					(
						'id'		=> 4,
						'parentId'	=> $criteria->getCriteriaValue('Parent')->getId()
					)
				)
			);	
		}
		
		return $array->getIterator();
	}
}