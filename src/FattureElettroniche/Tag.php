<?php
/***
 * F5 - Fatture elettroniche
 * 
 * Copyright © 2023
 * Reload - Laboratorio Multimediale
 * (https://www.reloadlab.it - info@reloadlab.it)
 * 
 * authors: Domenico Gigante (domenico.gigante@reloadlab.it)
 ***/

namespace F5\FattureElettroniche;
use \DOMDocument;
use \ReflectionClass;
use \ReflectionProperty;
use \F5\FattureElettroniche\ErrorsHandler as Errors;

abstract class Tag {
	
	protected static $_dom;
	
	/**
	 * Imposta la dipendenza di Errors
	 * 
	 * @return ErrorsHandler object
	 */
	public function err()
	{
		return Errors::get('F5\FattureElettroniche');
	}
	
	/**
	 * Imposta la dipendenza di Errors
	 * 
	 * @return ErrorsHandler object
	 */
	public function thr($throw = false)
	{
		if($this->err()->hasErrors()){
			
			if($throw){
				
				throw $this->err();
			}
			return;
		}
		
		return true;
	}
	
	/**
	 * Ritorna il valore di una proprietà
	 *
	 * @param string $name
	 *
	 * @return mixed (array|string|...)|void
	 */
	public function __get($name)
	{
		if($name[0] == '_'){
			
			$property = new ReflectionProperty($this, $name);
			$property->setAccessible(true);

			return $property->getValue($this);
		} elseif($name[0] != '_'){
			
			if($prop = $this->getName($name)){
				
				$property = new ReflectionProperty($this, $prop);
				$property->setAccessible(true);
				
				return $property->getValue($this);
			}
			
			$prop = '__'.$name;
			if($prop = $this->getName($prop)){
				
				$classname = 'F5\FattureElettroniche\\'.substr($prop, 2);
				
				if(!($this->{$prop} instanceof $classname)
					&& class_exists($classname)
				){
					$this->{$prop} = new $classname();
				}
				
				return $this->{$prop};
			}
		}
	}
	
	/**
	 * Imposta una proprietà 
	 *
	 * @param mixed (string|array) $key
	 * @param mixed $value
	 *
	 * @return Tags object
	 */
	public function set($key, $value = null)
	{
		if(is_array($key)){
			
			foreach($key as $k=>$v){
				
				$this->set($k, $v);
			}
		} elseif(is_string($key) && substr($key, 0, 1) != '_'){
			
			if($key = $this->getName($key)){
				
				$property = new ReflectionProperty($this, $key);
				$property->setAccessible(true);
				
				$property->setValue($this, $value);
			}
		}
		
		return $this;
	}
	
	/**
	 * Restituisce, se presente la corrispondenza, 
	 * il nome della proprietà protetta o privata che si intende scrivere
	 *
	 * @param mixed (string|array) $key
	 * @param mixed $value
	 *
	 * @return Tags object
	 */
	public function getName($name)
	{
		$reflection = new ReflectionClass($this);
		$vars = $reflection->getProperties(
			ReflectionProperty::IS_PRIVATE 
			| ReflectionProperty::IS_PROTECTED
		);
		
		if(count($vars)){
			
			foreach($vars as $privateVar){
				
				$prop = $privateVar->getName();
				if(strtolower($prop) == strtolower($name)){

					return $prop;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Instanzia DOMDocument
	 *
	 * @return null
	 */
	protected function createXML()
	{
		self::$_dom = new DOMDocument('1.0', 'utf-8');
		self::$_dom->preserveWhiteSpace = false;
		self::$_dom->formatOutput = true;
	}
	
	/**
	 * Salva la fattura in formato XML
	 *
	 * @param string $filename
	 *
	 * @return string
	 */
	protected function saveXML($filename = null)
	{
		$xml = self::$_dom->saveXML();
		
		if(isset($filename)){
			
			if(!file_put_contents($filename, $xml)){
			
				$this->err()->setErrors(_('Impossibile scrivere il file '.$filename));
			}
		}
		
		$this->thr();
		
		return $xml;
	}
}
