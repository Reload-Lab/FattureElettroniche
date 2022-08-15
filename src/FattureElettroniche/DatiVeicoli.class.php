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

class DatiVeicoli extends Tag {
	
	/**
	 * Data
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required yes
	 */
	protected $Data;
	
	/**
	 * Totale Percorso
	 * Formato alfanumerico; lunghezza massima di 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $TotalePercorso;
	
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
			
				// Data
				if($name == 'Data'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						
						$this->err()->setErrors(_('Data "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.$classname));
						return;
					}
				}
				
				// Totale Percorso
				if($name == 'TotalePercorso'){
					
					if(!is_string($value) 
						|| strlen($value) > 15
					){
						
						$this->err()->setErrors(_('Totale Percorso "'.$value.'": Formato alfanumerico; lunghezza massima di 15 caratteri in '.$classname));
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
		
		// Data
		if($this->Data != ''){
			
			$child = parent::$_dom->createElement('Data', $this->Data);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Data: Il tipo è obbligatorio in '.$classname));
		}
		
		// Totale Percorso
		if($this->TotalePercorso != ''){
			
			$child = parent::$_dom->createElement('TotalePercorso', $this->TotalePercorso);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Totale Percorso: Il tipo è obbligatorio in '.$classname));
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
		
		// Data
		if(isset($xmldata->Data) 
			&& $xmldata->Data instanceof SimpleXMLElement
			&& (string) $xmldata->Data != ''
		){
			
			$this->__set('Data', (string) $xmldata->Data);
		} else{
			
			$this->err()->setErrors(_('Data: Il tipo è obbligatorio in '.$classname));
		}
		
		// Totale Percorso
		if(isset($xmldata->TotalePercorso) 
			&& $xmldata->TotalePercorso instanceof SimpleXMLElement
			&& (string) $xmldata->TotalePercorso != ''
		){
			
			$this->__set('TotalePercorso', (string) $xmldata->TotalePercorso);
		} else{
			
			$this->err()->setErrors(_('Totale Percorso: Il tipo è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}