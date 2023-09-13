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

class DatiAnagraficiVettore extends Tag {
	
	/**
	 * Id Fiscale IVA
	 * @var object type IdFiscaleIVA
	 * @required yes
	 */
	protected $__IdFiscaleIVA;
	
	/**
	 * Codice Fiscale
	 * Formato alfanumerico; lunghezza compresa tra 11 e 16 caratteri
	 * @var string
	 * @required no
	 */
	protected $CodiceFiscale;
	
	/**
	 * Anagrafica
	 * @var object type Anagrafica
	 * @required yes
	 */
	protected $__Anagrafica;
	
	/**
	 * Numero Licenza Guida
	 * Formato alfanumerico; lunghezza massima di 20 caratteri
	 * @var string
	 * @required no
	 */
	protected $NumeroLicenzaGuida;
	
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
				
				// Codice Fiscale
				if($name == 'CodiceFiscale'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if((!preg_match('/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9A-Z]{3}[A-Z]$/i', $value) 
						&& !preg_match('/^[0-9]{11}$/', $value))
						|| strlen($value) < 11 
						|| strlen($value) > 16
					){
						$this->err()->setErrors(_('Codice Fiscale "'.$value.'": Formato alfanumerico; lunghezza compresa tra 11 e 16 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Numero Licenza Guida
				if($name == 'NumeroLicenzaGuida'){
					
					if(!is_string($value) 
						|| strlen($value) > 20
					){
						$this->err()->setErrors(_('Numero Licenza Guida "'.$value.'": Formato alfanumerico; lunghezza massima di 20 caratteri in '.__FILE__.' on line '.__LINE__));
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
		
		// Id Fiscale IVA
		if($this->__IdFiscaleIVA instanceof IdFiscaleIVA){
			
			$child = $this->__IdFiscaleIVA->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Id Fiscale IVA: Il tipo complesso è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Codice Fiscale
		if($this->CodiceFiscale != ''){
			
			$child = parent::$_dom->createElement('CodiceFiscale', $this->CodiceFiscale);
			
			$elem->appendChild($child);
		}
		
		// Anagrafica
		if($this->__Anagrafica instanceof Anagrafica){
			
			$child = $this->__Anagrafica->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Anagrafica: Il tipo complesso è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Numero Licenza Guida
		if($this->NumeroLicenzaGuida != ''){
			
			$child = parent::$_dom->createElement('NumeroLicenzaGuida', $this->NumeroLicenzaGuida);
			
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
		
		// Id Fiscale IVA
		if(isset($xmldata->IdFiscaleIVA) 
			&& $xmldata->IdFiscaleIVA instanceof SimpleXMLElement
		){
			if($xmldata->IdFiscaleIVA->count() == 1){
				
				$this->__IdFiscaleIVA = $this->IdFiscaleIVA
					->loopXml($xmldata->IdFiscaleIVA);
			} else{
				
				$this->err()->setErrors(_('Id Fiscale IVA: Il nodo deve essere presente una sola volta in '.__FILE__.' on line '.__LINE__));
			}
		} else{
			
			$this->err()->setErrors(_('Id Fiscale IVA: Il tipo complesso è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Codice Fiscale
		if(isset($xmldata->CodiceFiscale) 
			&& $xmldata->CodiceFiscale instanceof SimpleXMLElement
			&& (string) $xmldata->CodiceFiscale != ''
		){
			$this->__set('CodiceFiscale', (string) $xmldata->CodiceFiscale);
		}
	
		// Anagrafica
		if(isset($xmldata->Anagrafica) 
			&& $xmldata->Anagrafica instanceof SimpleXMLElement
		){
			if($xmldata->Anagrafica->count() == 1){
				
				$this->__Anagrafica = $this->Anagrafica
					->loopXml($xmldata->Anagrafica);
			} else{
				
				$this->err()->setErrors(_('Anagrafica: Il nodo deve essere presente una sola volta in '.__FILE__.' on line '.__LINE__));
			}
		} else{
			
			$this->err()->setErrors(_('Anagrafica: Il tipo complesso è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Numero Licenza Guida
		if(isset($xmldata->NumeroLicenzaGuida) 
			&& $xmldata->NumeroLicenzaGuida instanceof SimpleXMLElement
			&& (string) $xmldata->NumeroLicenzaGuida != ''
		){
			$this->__set('NumeroLicenzaGuida', (string) $xmldata->NumeroLicenzaGuida);
		}
		
		return $this;
	}
}
