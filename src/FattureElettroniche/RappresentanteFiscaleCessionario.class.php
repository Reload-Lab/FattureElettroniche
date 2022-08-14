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

class RappresentanteFiscaleCessionario extends Tag {
	
	/**
	 * Id Fiscale IVA
	 * @var object type IdFiscaleIVA
	 * @required yes
	 */
	protected $__IdFiscaleIVA;
	
	/**
	 * Denominazione
	 * Formato alfanumerico; lunghezza massima di 80 caratteri
	 * @var string
	 * @required no
	 */
	protected $Denominazione;
	
	/**
	 * Nome
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required no
	 */
	protected $Nome;
	
	/**
	 * Cognome
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required no
	 */
	protected $Cognome;
	
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
		
		$elem = parent::$_dom->createElement('RappresentanteFiscale');
		
		// IdFiscaleIVA
		if($this->__IdFiscaleIVA instanceof IdFiscaleIVA){
			
			$child = $this->__IdFiscaleIVA->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Id Fiscale IVA: Il tipo complesso è obbligatorio in '.$classname));
			return;
		}
		
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
				return;
			}
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
		
		// Id Fiscale IVA
		if(isset($xmldata->IdFiscaleIVA) 
			&& $xmldata->IdFiscaleIVA instanceof SimpleXMLElement
		){
			
			if($xmldata->IdFiscaleIVA->count() == 1){
				
				$this->__IdFiscaleIVA = $this->IdFiscaleIVA
					->loopXml($xmldata->IdFiscaleIVA);
			} else{
				
				$this->err()->setErrors(_('Id Fiscale IVA: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Id Fiscale IVA: Il tipo complesso è obbligatorio in '.$classname));
		}
		
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
			|| (string) $xmldata->Nome == '' 
			|| !isset($xmldata->Cognome) 
			|| !($xmldata->Cognome instanceof SimpleXMLElement)
			|| (string) $xmldata->Cognome == ''
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
		
		return $this;
	}
}