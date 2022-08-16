<?php
/***
 * F5 - Fatture elettroniche
 * 
 * Copyright © 2022
 * Reload - Laboratorio Multimediale
 * (https://www.reloadlab.it - info@reloadlab.it)
 * 
 * authors: Domenico Gigante (domenico.gigante@reloadlab.it)
 ***/

namespace F5\FattureElettroniche;
use \ReflectionClass;
use \ArrayAccess;

class RiferimentoNumeroLinea extends Tag implements ArrayAccess {
	
	/**
	 * Instances
	 * Array di valori
	 * @var array of object
	 */
	protected $_values = array();
	
	/**
	 * Restituisce gli elementi relativi a questo oggetto 
	 * e agli oggetti sotto di lui
	 *
	 * @return object (DOM element)
	 */
	public function getXml()
	{
		$reflect = new ReflectionClass($this);
		$classname = $reflect->getShortName();

		$arr = array();
		
		if(count($this->_values)){
			
			foreach($this->_values as $var){
				
				$elem = parent::$_dom->createElement($classname, $var);
				
				array_push($arr, $elem);
			}
		}
		
		return $arr;
	}
	
	public function offsetSet($offset, $value)
	{
		$reflect = new ReflectionClass($this);
		$classname = $reflect->getShortName();
		
		if(!preg_match('/^[a-zA-Z0-9]+$/', $value) 
			|| strlen($value) > 4
		){
			
			$this->err()->setErrors(_('Riferimento Numero Linea "'.$value.'": Formato alfanumerico; lunghezza massima di 4 caratteri in '.$classname));
			return;
		}
		
		if(is_null($offset)){
			
			$this->_values[] = $value;
		} else{
			
			$this->_values[$offset] = $value;
		}
	}

	public function offsetExists($offset)
	{
		return isset($this->_values[$offset]);
	}

	public function offsetUnset($offset)
	{
		unset($this->_values[$offset]);
	}

    public function offsetGet($offset)
	{
		return isset($this->_values[$offset])? $this->_values[$offset]: null;
    }
}