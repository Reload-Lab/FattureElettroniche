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
use \ReflectionClass;
use \ReflectionProperty;
use \SimpleXMLElement;

class ContattiTrasmittente extends Tag {
	
	/**
	 * Telefono
	 * Formato alfanumerico; lunghezza che va da 5 a 12 caratteri
	 * @var string
	 * @required no
	 */
	protected $Telefono;
	
	/**
	 * Email
	 * Formato alfanumerico; lunghezza che va da 7 a 256 caratteri
	 * @var string
	 * @required no
	 */
	protected $Email;
	
	/**
	 * Imposta una proprietà dell'oggetto
	 *
	 * @param string $name
	 * @param mixed $value
	 *
	 * @return void
	 */
	public function __set($name, $value)
	{
		if($name[0] != '_'){
			
			if($name = $this->getName($name)){
				
				$reflect = new ReflectionClass($this);
				$classname = $reflect->getShortName();
				
				// Telefono
				if($name == 'Telefono'){
					
					if(!is_string($value) 
						|| strlen($value) < 5 
						|| strlen($value) > 12
					){
						
						$this->err()->setErrors(_('Telefono "'.$value.'": Formato alfanumerico; lunghezza che va da 5 a 12 caratteri in '.$classname));
						return;
					}
				}
				
				// Email
				if($name == 'Email'){
					
					if(!is_string($value) 
						|| strlen($value) < 7 
						|| strlen($value) > 256
					){
						
						$this->err()->setErrors(_('Email "'.$value.'": Formato alfanumerico; lunghezza che va da 7 a 256 caratteri in '.$classname));
						return;
					}
				}
				
				$property = new ReflectionProperty($this, $name);
				$property->setAccessible(true);
				
				$property->setValue($this, $value);
			}
		}
	}
	
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
		
		$elem = parent::$_dom->createElement($classname);
		
		// Telefono
		if($this->Telefono != ''){
			
			$child = parent::$_dom->createElement('Telefono', $this->Telefono);
			
			$elem->appendChild($child);
		}
		
		// Email
		if($this->Email != ''){
			
			$child = parent::$_dom->createElement('Email', $this->Email);
			
			$elem->appendChild($child);
		}
		
		return $elem;
	}
	
	/**
	 * Prende un pezzo dell'oggetto xml 
	 * e restituisce una parte della fattura
	 *
	 * @return this
	 */
	public function loopXml($xmldata)
	{
		$reflect = new ReflectionClass($this);
		$classname = $reflect->getShortName();
		
		// Telefono
		if(isset($xmldata->Telefono) 
			&& $xmldata->Telefono instanceof SimpleXMLElement
			&& (string) $xmldata->Telefono != ''
		){
			
			$this->__set('Telefono', (string) $xmldata->Telefono);
		}
		
		// Email
		if(isset($xmldata->Email) 
			&& $xmldata->Email instanceof SimpleXMLElement
			&& (string) $xmldata->Email != ''
		){
			
			$this->__set('Email', (string) $xmldata->Email);
		}
		
		return $this;
	}
}