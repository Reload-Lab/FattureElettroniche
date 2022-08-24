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

class DatiSAL extends Tag {
	
	/**
	 * Riferimento Fase
	 * Formato numerico; lunghezza massima di 3 caratteri
	 * @var string
	 * @required no
	 */
	protected $RiferimentoFase;
	
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
				
				// Riferimento Fase
				if($name == 'RiferimentoFase'){
					
					if(!preg_match('/^[0-9]+$/', $value) 
						|| strlen($value) > 3
					){
						
						$this->err()->setErrors(_('Riferimento Fase "'.$value.'": Formato numerico; lunghezza massima di 3 caratteri in '.$classname));
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
		
		// Riferimento Fase
		if($this->RiferimentoFase != ''){
			
			$child = parent::$_dom->createElement('RiferimentoFase', $this->RiferimentoFase);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Riferimento Fase: Il tipo è obbligatorio in '.$classname));
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
		
		// Riferimento Fase
		if(isset($xmldata->RiferimentoFase) 
			&& $xmldata->RiferimentoFase instanceof SimpleXMLElement
			&& (string) $xmldata->RiferimentoFase != ''
		){
			
			$this->__set('RiferimentoFase', (string) $xmldata->RiferimentoFase);
		} else{
			
			$this->err()->setErrors(_('Riferimento Fase: Il tipo è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}