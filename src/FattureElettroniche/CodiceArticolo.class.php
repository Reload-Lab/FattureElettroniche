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
use \ReflectionProperty;
use \SimpleXMLElement;
use \ArrayAccess;

class CodiceArticolo extends Tag implements ArrayAccess {
	
	use OffsetArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Codice Tipo
	 * Formato alfanumerico; lunghezza massima di 35 caratteri
	 * @var string
	 * @required yes
	 */
	protected $CodiceTipo;
	
	/**
	 * Codice Valore
	 * Formato alfanumerico; lunghezza massima di 35 caratteri
	 * @var string
	 * @required yes
	 */
	protected $CodiceValore;
	
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
				
				// Codice Tipo
				if($name == 'CodiceTipo'){
					
					if(!is_string($value) 
						|| strlen($value) > 35
					){
						
						$this->err()->setErrors(_('Codice Tipo "'.$value.'": Formato alfanumerico; lunghezza massima di 35 caratteri in '.$classname));
						return;
					}
				}
				
				// Codice Valore
				if($name == 'CodiceValore'){
					
					if(!is_string($value) 
						|| strlen($value) > 35
					){
						
						$this->err()->setErrors(_('Codice Valore "'.$value.'": Formato alfanumerico; lunghezza massima di 35 caratteri in '.$classname));
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

		$arr = array();
		
		if(count($this->_instances)){
			
			foreach($this->_instances as $var){
				
				$elem = parent::$_dom->createElement($classname);
		
				// Codice Tipo
				if($var->CodiceTipo != ''){
					
					$child = parent::$_dom->createElement('CodiceTipo', $var->CodiceTipo);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Codice Tipo: Il tipo è obbligatorio in '.$classname));
				}
				
				// Codice Valore
				if($var->CodiceValore != ''){
					
					$child = parent::$_dom->createElement('CodiceValore', $var->CodiceValore);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Codice Valore: Il tipo è obbligatorio in '.$classname));
				}
				
				array_push($arr, $elem);
			}
		}
		
		return $arr;
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
		
		// Codice Tipo
		if(isset($xmldata->CodiceTipo) 
			&& $xmldata->CodiceTipo instanceof SimpleXMLElement
			&& (string) $xmldata->CodiceTipo != ''
		){
			
			$this->__set('CodiceTipo', (string) $xmldata->CodiceTipo);
		} else{
			
			$this->err()->setErrors(_('Codice Tipo: Il tipo è obbligatorio in '.$classname));
		}
		
		// Codice Valore
		if(isset($xmldata->CodiceValore) 
			&& $xmldata->CodiceValore instanceof SimpleXMLElement
			&& (string) $xmldata->CodiceValore != ''
		){
			
			$this->__set('CodiceValore', (string) $xmldata->CodiceValore);
		} else{
			
			$this->err()->setErrors(_('Codice Valore: Il tipo è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}