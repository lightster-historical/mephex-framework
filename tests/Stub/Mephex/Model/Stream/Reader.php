<?php



class Stub_Mephex_Model_Stream_Reader
extends Mephex_Model_Stream_Reader
{
	public function read(Mephex_Model_Criteria $criteria)
	{
		if($criteria->hasCriteriaFields($keys = array('Id')))
		{
			$array	= new ArrayObject
			(
				array
				(
					array
					(
						'id'		=> $criteria->getCriteriaValue('Id'),
						'parent'	=> 'parent_of_' . $criteria->getCriteriaValue('Id')
					)
				)
			);
		}
		else if($criteria->hasCriteriaFields($keys = array('Parent')))
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