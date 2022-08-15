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

class IdTrasmittente extends Tag {
	
	/**
	 * Id Paese
	 * Sigla della nazione espressa secondo lo standard ISO 3166-1 alpha-2 code
	 * @var string
	 * @required yes
	 */
	protected $IdPaese;
	
	/**
	 * Id Codice
	 * Formato alfanumerico; lunghezza massima di 28 caratteri
	 * @var string
	 * @required yes
	 */
	protected $IdCodice;
	
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
				
				// Id Paese
				if($name == 'IdPaese'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!preg_match('/^[A-Z]+$/', $value) 
						|| strlen($value) != 2
					){
						
						$this->err()->setErrors(_('Id Paese "'.$value.'": Sigla della nazione espressa secondo lo standard ISO 3166-1 alpha-2 code in '.$classname));
						return;
					}
				}
				
				// Id Codice
				if($name == 'IdCodice'){
					
					if(!preg_match('/^[a-zA-Z0-9]+$/', $value) 
						|| strlen($value) > 28
					){
						
						$this->err()->setErrors(_('Id Codice "'.$value.'": Formato alfanumerico; lunghezza massima di 28 caratteri in '.$classname));
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
		
		// Id Paese
		if($this->IdPaese != ''){
			
			$child = parent::$_dom->createElement('IdPaese', $this->IdPaese);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Id Paese: Il tipo è obbligatorio in '.$classname));
		}
		
		// Id Codice
		if($this->IdCodice != ''){
			
			$child = parent::$_dom->createElement('IdCodice', $this->IdCodice);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Id Codice: Il tipo è obbligatorio in '.$classname));
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
		
		// Id Paese
		if(isset($xmldata->IdPaese) 
			&& $xmldata->IdPaese instanceof SimpleXMLElement
			&& (string) $xmldata->IdPaese != ''
		){
			
			$this->__set('IdPaese', (string) $xmldata->IdPaese);
		} else{
			
			$this->err()->setErrors(_('Id Paese: Il tipo è obbligatorio in '.$classname));
		}
		
		// Id Codice
		if(isset($xmldata->IdCodice) 
			&& $xmldata->IdCodice instanceof SimpleXMLElement
			&& (string) $xmldata->IdCodice != ''
		){
			
			$this->__set('IdCodice', (string) $xmldata->IdCodice);
		} else{
			
			$this->err()->setErrors(_('Id Codice: Il tipo è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}