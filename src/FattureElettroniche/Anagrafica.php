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

class Anagrafica extends Tag {
	
	/**
	 * Denominazione
	 * Formato alfanumerico; lunghezza massima di 80 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Denominazione;
	
	/**
	 * Nome
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Nome;
	
	/**
	 * Cognome
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Cognome;
	
	/**
	 * Titolo
	 * Formato alfanumerico; lunghezza che va da 2 a 10 caratteri
	 * @var string
	 * @required no
	 */
	protected $Titolo;
	
	/**
	 * Codice EORI
	 * Formato alfanumerico; lunghezza che va da 13 a 17 caratteri
	 * @var string
	 * @required no
	 */
	protected $CodEORI;
	
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
				
				// Denominazione
				if($name == 'Denominazione'){
					
					if(!is_string($value) 
						|| strlen($value) > 80
					){
						
						$this->err()->setErrors(_('Denominazione "'.$value.'": Formato alfanumerico; lunghezza massima di 80 caratteri in '.$classname));
						return;
					}
				}
				
				// Nome
				if($name == 'Nome'){
					
					if(!is_string($value) 
						|| strlen($value) > 60
					){
						
						$this->err()->setErrors(_('Nome "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.$classname));
						return;
					}
				}
				
				// Cognome
				if($name == 'Cognome'){
					
					if(!is_string($value) 
						|| strlen($value) > 60
					){
						
						$this->err()->setErrors(_('Cognome "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.$classname));
						return;
					}
				}
				
				// Titolo
				if($name == 'Titolo'){
					
					if(!is_string($value) 
						|| strlen($value) < 2 
						|| strlen($value) > 10
					){
						
						$this->err()->setErrors(_('Titolo "'.$value.'": Formato alfanumerico; lunghezza che va da 2 a 10 caratteri in '.$classname));
						return;
					}
				}
				
				// Codice EORI
				if($name == 'CodEORI'){
					
					if(!is_string($value) 
						|| strlen($value) < 13 
						|| strlen($value) > 17
					){
						
						$this->err()->setErrors(_('Codice EORI "'.$value.'": Formato alfanumerico; lunghezza che va da 13 a 17 caratteri in '.$classname));
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
		
		// Nome
		if($this->Nome != '' && $this->Cognome != ''){
			
			$child = parent::$_dom->createElement('Nome', $this->Nome);
			
			$elem->appendChild($child);
		}
		
		// Cognome
		if($this->Nome != '' && $this->Cognome != ''){
			
			$child = parent::$_dom->createElement('Cognome', $this->Cognome);
			
			$elem->appendChild($child);
		}
		
		if($this->Nome == '' || $this->Cognome == ''){
			
			// Denominazione
			if($this->Denominazione != ''){
				
				$child = parent::$_dom->createElement('Denominazione', $this->Denominazione);
				
				$elem->appendChild($child);
			} else{
				
				$this->err()->setErrors(_('Denominazione: Il tipo è obbligatorio in '.$classname));
			}
		}
		
		// Titolo
		if($this->Titolo != ''){
			
			$child = parent::$_dom->createElement('Titolo', $this->Titolo);
			
			$elem->appendChild($child);
		}
		
		// Codice EORI
		if($this->CodEORI != ''){
			
			$child = parent::$_dom->createElement('CodEORI', $this->CodEORI);
			
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
		
		// Nome
		if(isset($xmldata->Nome) 
			&& $xmldata->Nome instanceof SimpleXMLElement
			&& (string) $xmldata->Nome != '' 
			&& isset($xmldata->Cognome) 
			&& $xmldata->Cognome instanceof SimpleXMLElement
			&& (string) $xmldata->Cognome != ''
		){
			
			$this->__set('Nome', (string) $xmldata->Nome);
		}
		
		// Cognome
		if(isset($xmldata->Nome) 
			&& $xmldata->Nome instanceof SimpleXMLElement
			&& (string) $xmldata->Nome != '' 
			&& isset($xmldata->Cognome) 
			&& $xmldata->Cognome instanceof SimpleXMLElement
			&& (string) $xmldata->Cognome != ''
		){
			
			$this->__set('Cognome', (string) $xmldata->Cognome);
		}
		
		if(!isset($xmldata->Nome) 
			|| !($xmldata->Nome instanceof SimpleXMLElement)
			|| $xmldata->Nome == '' 
			|| !isset($xmldata->Cognome) 
			|| !($xmldata->Cognome instanceof SimpleXMLElement)
			|| $xmldata->Cognome == ''
		){
		
			// Denominazione
			if(isset($xmldata->Denominazione) 
				&& $xmldata->Denominazione instanceof SimpleXMLElement
				&& (string) $xmldata->Denominazione != ''
			){
				
				$this->__set('Denominazione', (string) $xmldata->Denominazione);
			} else{
				
				$this->err()->setErrors(_('Denominazione: Il tipo è obbligatorio in '.$classname));
			}
		}
		
		// Titolo
		if(isset($xmldata->Titolo) 
			&& $xmldata->Titolo instanceof SimpleXMLElement
			&& (string) $xmldata->Titolo != ''
		){
			
			$this->__set('Titolo', (string) $xmldata->Titolo);
		}
		
		// Codice EORI
		if(isset($xmldata->CodEORI) 
			&& $xmldata->CodEORI instanceof SimpleXMLElement
			&& (string) $xmldata->CodEORI != ''
		){
			
			$this->__set('CodEORI', (string) $xmldata->CodEORI);
		}
		
		return $this;
	}
}