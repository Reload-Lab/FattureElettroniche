<?php
/***
 * F5 - Fatture elettroniche
 * 
 * Copyright © 2022
 * Reload - Laboratorio Multimediale
 * (http://www.reloadlab.it - info@reloadlab.it)
 * 
 * authors: Domenico Gigante (domenico.gigante@reloadlab.it)
 ***/

namespace F5\FattureElettroniche;

trait OffsetArray {
	
	public function offsetSet($offset, $value)
	{
		$classname = get_class($this);

		if($value instanceof $classname){
			
			if(is_null($offset)){
				
				$this->_instances[] = $value;
			} else{
				
				$this->_instances[$offset] = $value;
			}
		}
	}

	public function offsetExists($offset)
	{
		$classname = get_class($this);
		
		return isset($this->_instances[$offset]) && $this->_instances[$offset] instanceof $classname;
	}

	public function offsetUnset($offset)
	{
		unset($this->_instances[$offset]);
	}

    public function offsetGet($offset)
	{
		$classname = get_class($this);
		
		if(isset($this->_instances[$offset]) && $this->_instances[$offset] instanceof $classname){
			
			return $this->_instances[$offset];
		} else{
			
			return $this->_instances[$offset] = self::create($classname);
		}
    }
	
	public static function create($class)
	{
		return new $class();
    }
}