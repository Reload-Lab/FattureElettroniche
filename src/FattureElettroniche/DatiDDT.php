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
use \ReflectionClass;
use \ReflectionProperty;
use \SimpleXMLElement;
use \DOMNode;
use \ArrayAccess;
use \Iterator;
use \Countable;

class DatiDDT extends Tag implements ArrayAccess, Iterator, Countable {
	
	use OffsetArray;
	use IteratorArray;
	use CountArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Numero DDT
	 * Formato alfanumerico; lunghezza massima di 20 caratteri
	 * @var string
	 * @required yes
	 */
	protected $NumeroDDT;
	
	/**
	 * Data DDT
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required yes
	 */
	protected $DataDDT;
	
	/**
	 * Riferimento Numero Linea
	 * @var object type RiferimentoNumeroLinea
	 * @required no
	 */
	protected $__RiferimentoNumeroLinea;
	
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
				
				// Numero DDT
				if($name == 'NumeroDDT'){
					
					if((!is_string($value) 
						&& !is_numeric($value))
						|| strlen($value) > 20
					){
						$this->err()->setErrors(_('Numero DDT "'.$value.'": Formato alfanumerico; lunghezza massima di 20 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Data DDT
				if($name == 'DataDDT'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						$this->err()->setErrors(_('Data DDT "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.__FILE__.' on line '.__LINE__));
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
				
				// Numero DDT
				if($var->NumeroDDT != ''){
					
					$child = parent::$_dom->createElement('NumeroDDT', $var->NumeroDDT);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Numero DDT: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
				}
				
				// Data DDT
				if($var->DataDDT != ''){
					
					$child = parent::$_dom->createElement('DataDDT', $var->DataDDT);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Data DDT: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
				}
				
				// Riferimento Numero Linea
				if($var->__RiferimentoNumeroLinea instanceof RiferimentoNumeroLinea){
					
					$childs = $var->__RiferimentoNumeroLinea->getXml();
					
					if(count($childs)){
						
						foreach($childs as $var2){
							
							if($var2 instanceof DOMNode){
								
								$elem->appendChild($var2);
							}
						}
					}
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
		
		// Numero DDT
		if(isset($xmldata->NumeroDDT) 
			&& $xmldata->NumeroDDT instanceof SimpleXMLElement
			&& (string) $xmldata->NumeroDDT != ''
		){
			$this->__set('NumeroDDT', (string) $xmldata->NumeroDDT);
		} else{
			
			$this->err()->setErrors(_('Numero DDT: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Data DDT
		if(isset($xmldata->DataDDT) 
			&& $xmldata->DataDDT instanceof SimpleXMLElement
			&& (string) $xmldata->DataDDT != ''
		){
			$this->__set('DataDDT', (string) $xmldata->DataDDT);
		} else{
			
			$this->err()->setErrors(_('Data DDT: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Riferimento Numero Linea
		if(isset($xmldata->RiferimentoNumeroLinea)
			&& $xmldata->RiferimentoNumeroLinea instanceof SimpleXMLElement
		){
			if($xmldata->RiferimentoNumeroLinea->count() > 1){
				
				for($k = 0; $k < $xmldata->RiferimentoNumeroLinea->count(); $k++){
					
					$this->__RiferimentoNumeroLinea[$k] = (string) $xmldata->RiferimentoNumeroLinea[$k];
				}
			} elseif($xmldata->RiferimentoNumeroLinea->count() == 1){
				
				$this->__RiferimentoNumeroLinea[0] = (string) $xmldata->RiferimentoNumeroLinea;
			}
		}
		
		return $this;
	}
}
