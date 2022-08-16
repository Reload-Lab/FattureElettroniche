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

class FatturaPrincipale extends Tag {
	
	/**
	 * Numero Fattura Principale
	 * Formato alfanumerico; lunghezza massima di 20 caratteri
	 * @var string
	 * @required yes
	 */
	protected $NumeroFatturaPrincipale;
	
	/**
	 * Data Fattura Principale
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required yes
	 */
	protected $DataFatturaPrincipale;
	
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
				
				// Numero Fattura Principale
				if($name == 'NumeroFatturaPrincipale'){
					
					if(!is_string($value) 
						|| strlen($value) > 20
					){
						
						$this->err()->setErrors(_('Numero Fattura Principale "'.$value.'": Formato alfanumerico; lunghezza massima di 20 caratteri in '.$classname));
						return;
					}
				}
				
				// Data Fattura Principale
				if($name == 'DataFatturaPrincipale'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						
						$this->err()->setErrors(_('Data Fattura Principale "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.$classname));
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
		
		// Numero Fattura Principale
		if($this->NumeroFatturaPrincipale != ''){
			
			$child = parent::$_dom->createElement('NumeroFatturaPrincipale', $this->NumeroFatturaPrincipale);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Numero Fattura Principale: Il tipo è obbligatorio in '.$classname));
		}
		
		// Data Fattura Principale
		if($this->DataFatturaPrincipale != ''){
			
			$child = parent::$_dom->createElement('DataFatturaPrincipale', $this->DataFatturaPrincipale);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Data Fattura Principale: Il tipo è obbligatorio in '.$classname));
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
		
		// Numero Fattura Principale
		if(isset($xmldata->NumeroFatturaPrincipale) 
			&& $xmldata->NumeroFatturaPrincipale instanceof SimpleXMLElement
			&& (string) $xmldata->NumeroFatturaPrincipale != ''
		){
			
			$this->__set('NumeroFatturaPrincipale', (string) $xmldata->NumeroFatturaPrincipale);
		} else{
			
			$this->err()->setErrors(_('Numero Fattura Principale: Il tipo è obbligatorio in '.$classname));
		}
		
		// Data Fattura Principale
		if(isset($xmldata->DataFatturaPrincipale) 
			&& $xmldata->DataFatturaPrincipale instanceof SimpleXMLElement
			&& (string) $xmldata->DataFatturaPrincipale != ''
		){
			
			$this->__set('DataFatturaPrincipale', (string) $xmldata->DataFatturaPrincipale);
		} else{
			
			$this->err()->setErrors(_('Data Fattura Principale: Il tipo è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}