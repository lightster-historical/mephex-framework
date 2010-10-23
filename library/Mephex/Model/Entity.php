<?php



/**
 * An entity that represents a specific type of object.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Entity
{
	/**
	 * 'State' constant that declares the object to be
	 * unchanged since its last save.
	 * 
	 * @var int
	 */
	const STATE_CLEAN	= 1;
	/**
	 * 'State' constant that declares the object to be
	 * new and never-saved.
	 * 
	 * @var int
	 */
	const STATE_NEW		= 2;
	/**
	 * 'State' constant that declares the object to be
	 * changed since its last save.
	 * 
	 * @var int
	 */
	const STATE_DIRTY	= 4;
	/**
	 * 'State' constant that declares the object to be
	 * deleted.
	 * 
	 * @var int
	 */
	const STATE_DELETED	= 8;
	
	
	
	/**
	 * The entity's current state.
	 * 
	 * @var STATE enum
	 */
	private $_entity_state	= self::STATE_NEW;
	
	
	
	/**
	 * Returns an identifier that makes this object unique
	 * within its entity type.
	 * 
	 * @return string
	 */
	public abstract function getUniqueIdentifier();
	
	
	
	/**
	 * Returns the property of the given name.
	 * 
	 * @param string $name
	 * @return mixed
	 */
	protected function getProperty($name)
	{
		// using isset before property_exists is an optimization that
		// assumes that properties will be non-null more often than they
		// will not [ O(isset) < O(property_exists) ]
		if(!isset($this->{$name}) && !property_exists($this, $name))
		{
			throw new Mephex_Model_Entity_Exception_UnknownProperty($this, $name);
		}
		
		$property	= $this->{$name};
		
		if($property instanceof Mephex_Model_Entity_Reference)
		{
			$property		= $property->getEntity();
			$method_name	= 'set' . $name;
			if(method_exists($this, $method_name))
			{
				$this->$method_name($property);
			}
			else
			{
				$this->setProperty($name, $property);
			}
		}
		
		return $this->{$name};
	}
	
	
	
	/**
	 * Retrieves an array containing the values of each of the requested
	 * properties.
	 * 
	 * @param array $properties - the names of the properties to retrieve
	 * @return array
	 */
	protected function getProperties(array $properties)
	{
		$values	= array();
		foreach($properties as $property)
		{
			$values[$property]	= $this->getProperty($property);
		}
		
		return $values;
	}
	
	
	
	/**
	 * Sets the property of the given name to the given value.
	 * 
	 * @param string $name
	 * @param mixed $value
	 */
	protected function setProperty($name, $value)
	{
		// using isset before property_exists is an optimization that
		// assumes that properties will be non-null more often than they
		// will not [ O(isset) < O(property_exists) ]
		if(!isset($this->{$name}) && !property_exists($this, $name))
		{
			throw new Mephex_Model_Entity_Exception_UnknownProperty($this, $name);
		}
		
		$this->{$name}	= $value;
		
		return $this;
	}
	
	
	
	/**
	 * Retrieves an array of property values from the entity (referenced or 
	 * otherwise) found in the given property.
	 * 
	 * @param string $name - the name of the property that contains the entity
	 * 		or reference
	 * @param array $criteria_props - the names of the properties within the
	 * 		entity that are to be retrieved
	 * @return array
	 */
	public function getReferencedPropertyCriteriaValues($name, array $criteria_props)
	{		
		// using isset before property_exists is an optimization that
		// assumes that properties will be non-null more often than they
		// will not [ O(isset) < O(property_exists) ]
		if(!isset($this->{$name}) && !property_exists($this, $name))
		{
			throw new Mephex_Model_Entity_Exception_UnknownProperty($this, $name);
		}
		
		// make sure the property can be set to a reference
		if(!$this->isReferencedPropertyAllowed($name))
		{
			throw new Mephex_Model_Exception_UnallowedReference($this, $name);
		}
		
		// attempt to load the property values from the reference's criteria
		$prop_value	= $this->{$name};
		if($prop_value instanceof Mephex_Model_Entity_Reference)
		{
			try
			{
				return $prop_value->getCriteria()->getCriteriaValues($criteria_props);					
			}
			catch(Mephex_Exception $ex)
			{
			}
		}
		
		// attempt to load the properties from the dereferenced entity property
		$prop_value	= $this->getProperty($name);
		if($prop_value instanceof Mephex_Model_Entity)
		{
			return $prop_value->getProperties($criteria_props);
		}
		
		throw new Mephex_Exception("Property '{$name}' is not an entity.");
	}
	
	
	
	/**
	 * Sets the property of the given name to the given referenced
	 * value.
	 * 
	 * @param string $name
	 * @param Mephex_Model_Entity_Reference $reference
	 */
	public function setReferencedProperty($name, Mephex_Model_Entity_Reference $reference)
	{
		// using isset before property_exists is an optimization that
		// assumes that properties will be non-null more often than they
		// will not [ O(isset) < O(property_exists) ]
		if(!isset($this->{$name}) && !property_exists($this, $name))
		{
			throw new Mephex_Model_Entity_Exception_UnknownProperty($this, $name);
		}
		
		if(!$this->isReferencedPropertyAllowed($name))
		{
			throw new Mephex_Model_Exception_UnallowedReference($this, $name, $reference);
		}
		
		$this->{$name}	= $reference;
		
		return $this;
	}
	
	
	
	/**
	 * Determines if the property of the given name is allowed
	 * to be set to a reference.
	 * 
	 * @param bool $name
	 */
	protected function isReferencedPropertyAllowed($name)
	{
		return false;
	}
	
	
	
	/**
	 * Marks the entity as deleted.
	 * 
	 * @return void
	 */
	public function markDeleted()
	{
		$this->_entity_state	= self::STATE_DELETED;
	}
	
	
	
	/**
	 * Marks the entity as saved and unchanged.
	 * 
	 * @return void
	 */
	public function markClean()
	{
		$this->_entity_state	= self::STATE_CLEAN;
	}
	
	
	
	/**
	 * Marks the entity as changed since last being saved.
	 * 
	 * @return void
	 */
	public function markDirty()
	{
		$this->_entity_state	= self::STATE_DIRTY;
	}
	
	
	
	/**
	 * Marks the entity as new and unsaved.
	 * 
	 * @return void
	 */
	public function markNew()
	{
		$this->_entity_state	= self::STATE_NEW;
	}
	
	
	
	/**
	 * Determines if the entity is marked dirty. 
	 * 
	 * @return bool
	 */
	public function isMarkedDirty()
	{
		return (bool)($this->_entity_state & self::STATE_DIRTY);
	}
	
	
	
	/**
	 * Determines if the entity is marked deleted. 
	 * 
	 * @return bool
	 */
	public function isMarkedDeleted()
	{
		return (bool)($this->_entity_state & self::STATE_DELETED);
	}
	
	
	
	/**
	 * Determines if the entity is marked clean. 
	 * 
	 * @return bool
	 */
	public function isMarkedClean()
	{
		return (bool)($this->_entity_state & self::STATE_CLEAN);
	}
	
	
	
	/**
	 * Determines if the entity is marked new. 
	 * 
	 * @return bool
	 */
	public function isMarkedNew()
	{
		return (bool)($this->_entity_state & self::STATE_NEW);
	}
	
	
	
	/**
	 * Determines if the entity is marked deleted. 
	 * 
	 * @return bool
	 */
	public final static function checkEntityType(Mephex_Model_Entity $entity, $class_name)
	{
		if(!($entity instanceof $class_name))
		{
			throw new Mephex_Model_Exception_UnexpectedEntityType($entity, $class_name);
		}
		
		return true;
	}
}