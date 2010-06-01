<?php



/**
 * An entity that represents a specific type of collection.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Entity_Collection
extends Mephex_Model_Entity
implements 
	Iterator,
	Countable
{
	/**
	 * The offset of the element the iterator is currently pointing at.
	 * @var unknown_type
	 */
	private $_current	= 0;
	
	/**
	 * The unique identifier of each entity.
	 * @var array
	 */
	private $_uids		= array();
	
	/**
	 * The entities added to the collection.
	 * @var array
	 */
	private $_entities	= array();
	
	/**
	 * The number of entities in the collection.
	 * @var int
	 */
	private $_count		= 0;
	
	
	
	/**
	 * Adds an entity, reference, or other value to the collection.
	 * 
	 * @param mixed $entity - the entity/reference being added to
	 * 		the collection
	 */
	protected function add($entity)
	{
		if($entity instanceof Mephex_Model_Entity)
		{
			$this->_uids[]		= $entity->getUniqueIdentifier();
		}
		else
		{
			$this->_uids[]		= null;
		}
		
		$this->_entities[]	= $entity;
		$this->_count++;
	}
	
	
	
	/**
	 * Checks the given offset for a reference. If the offset
	 * holds a reference, an entity is loaded. 
	 * 
	 * @param unknown_type $index
	 */
	protected function loadEntity($index)
	{
		$property	= $this->_entities[$index];
		
		if($property instanceof Mephex_Model_Entity_Reference)
		{
			$this->_entities[$index]	= $property->getEntity();
			$this->_uids[$index]
				= $this->_entities[$index]->getUniqueIdentifier();
		}
	}
	
	
	
	/**
	 * Returns the current element.
	 * 
	 * @return mixed
	 */
	public function current()
	{
		$this->loadEntity($this->_current);
		return $this->_entities[$this->_current];
	}
	
	
	
	/**
	 * Returns the key of the current element.
	 * 
	 * @return mixed
	 */
	public function key()
	{
		$this->loadEntity($this->_current);
		return $this->_uids[$this->_current];
	}
	
	
	
	/**
	 * Increments the iterator pointer by 1.
	 * 
	 * @return void
	 */
	public function next()
	{
		$this->_current++;
	}
	
	
	
	/**
	 * Rewinds the iterator to the first element.
	 * 
	 * @return void
	 */
	public function rewind()
	{
		$this->_current	= 0;
	}
	
	
	
	/**
	 * Checks the iterator pointer to see if it is pointing
	 * to a valid element. 
	 * 
	 * @return bool
	 */
	public function valid()
	{
		return ($this->_current < $this->_count);
	}
	
	
	
	/**
	 * Returns the number of elements in the collection.
	 * 
	 * @return int
	 */
	public function count()
	{
		return $this->_count;
	}
}