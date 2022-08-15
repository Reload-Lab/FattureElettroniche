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
use \DOMNode;

class DatiAnagrafici extends Tag {
	
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
	 * Albo Professionale
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required no
	 */
	protected $AlboProfessionale;
	
	/**
	 * Provincia Albo
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required no
	 */
	protected $ProvinciaAlbo;
	
	/**
	 * Numero Iscrizione Albo
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required no
	 */
	protected $NumeroIscrizioneAlbo;
	
	/**
	 * Data Iscrizione Albo
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required no
	 */
	protected $DataIscrizioneAlbo;
	
	/**
	 * Regime Fiscale
	 * Formato alfanumerico; lunghezza di 4 caratteri
	 * @var string
	 * @required yes
	 */
	protected $RegimeFiscale;
	
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
					
					if((!preg_match('/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/i', $value) 
						&& !preg_match('/^[0-9]{11}$/', $value))
						|| strlen($value) < 11 
						|| strlen($value) > 16
					){
						
						$this->err()->setErrors(_('Codice Fiscale "'.$value.'": Formato alfanumerico; lunghezza compresa tra 11 e 16 caratteri in '.$classname));
						return;
					}
				}
				
				// Albo Professionale
				if($name == 'AlboProfessionale'){
					
					if(!is_string($value) 
						|| strlen($value) > 60
					){
						
						$this->err()->setErrors(_('Albo Professionale "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.$classname));
						return;
					}
				}
				
				// Provincia Albo
				if($name == 'ProvinciaAlbo'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$PI[$value])){
						
						$this->err()->setErrors(_('Provincia Albo "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.$classname));
						return;
					}
				}
				
				// Numero Iscrizione Albo
				if($name == 'NumeroIscrizioneAlbo'){
					
					if(!is_string($value) 
						|| strlen($value) > 60
					){
						
						$this->err()->setErrors(_('NumeroIscrizione Albo "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.$classname));
						return;
					}
				}
				
				// Data Iscrizione Albo
				if($name == 'DataIscrizioneAlbo'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						
						$this->err()->setErrors(_('DataIscrizioneAlbo "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.$classname));
						return;
					}
				}
				
				// Regime Fiscale
				if($name == 'RegimeFiscale'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$RF[$value])){
						
						$this->err()->setErrors(_('RegimeFiscale "'.$value.'": Formato alfanumerico; lunghezza di 4 caratteri in '.$classname));
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
	 * @param string $parent
	 *
	 * @return object (DOM element)
	 */
	public function getXml($parent = null)
	{
		$reflect = new ReflectionClass($this);
		$classname = $reflect->getShortName();
		
		$elem = parent::$_dom->createElement($classname);
		
		if($parent == 'CessionarioCommittente'){
			
			// Codice Fiscale
			if($this->CodiceFiscale != ''){
				
				$child = parent::$_dom->createElement('CodiceFiscale', $this->CodiceFiscale);
				
				$elem->appendChild($child);
			} else{
				
				// Id Fiscale IVA
				if($this->__IdFiscaleIVA instanceof IdFiscaleIVA){
					
					$child = $this->__IdFiscaleIVA->getXml();
					
					if($child instanceof DOMNode){
	
						$elem->appendChild($child);
					}
				} else{
				
					$this->err()->setErrors(_('IdFiscaleIVA: Il tipo complesso è obbligatorio in '.$classname));
				}
			}
		} else{
				
			// Id Fiscale IVA
			if($this->__IdFiscaleIVA instanceof IdFiscaleIVA){
				
				$child = $this->__IdFiscaleIVA->getXml();
				
				if($child instanceof DOMNode){
	
					$elem->appendChild($child);
				}
			} else{
				
				$this->err()->setErrors(_('Id Fiscale IVA: Il tipo complesso è obbligatorio in '.$classname));
			}
			
			// Codice Fiscale
			if($this->CodiceFiscale != ''){
				
				$child = parent::$_dom->createElement('CodiceFiscale', $this->CodiceFiscale);
				
				$elem->appendChild($child);
			}
		}
		
		// Anagrafica
		if($this->__Anagrafica instanceof Anagrafica){
			
			$child = $this->__Anagrafica->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Anagrafica: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		if($parent == 'CedentePrestatore'){
				
			// Albo Professionale
			if($this->AlboProfessionale != ''){
				
				$child = parent::$_dom->createElement('AlboProfessionale', $this->AlboProfessionale);
				
				$elem->appendChild($child);
			}
			
			// Provincia Albo
			if($this->ProvinciaAlbo != ''){
				
				$child = parent::$_dom->createElement('ProvinciaAlbo', $this->ProvinciaAlbo);
				
				$elem->appendChild($child);
			}
			
			// Numero Iscrizione Albo
			if($this->NumeroIscrizioneAlbo != ''){
				
				$child = parent::$_dom->createElement('NumeroIscrizioneAlbo', $this->NumeroIscrizioneAlbo);
				
				$elem->appendChild($child);
			}
			
			// Data Iscrizione Albo
			if($this->DataIscrizioneAlbo != ''){
				
				$child = parent::$_dom->createElement('DataIscrizioneAlbo', $this->DataIscrizioneAlbo);
				
				$elem->appendChild($child);
			}
			
			// Regime Fiscale
			if($this->RegimeFiscale != ''){
				
				$child = parent::$_dom->createElement('RegimeFiscale', $this->RegimeFiscale);
				
				$elem->appendChild($child);
			} else{
			
				$this->err()->setErrors(_('Regime Fiscale: Il tipo è obbligatorio in '.$classname));
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
	public function loopXml($xmldata, $parent = null)
	{
		$reflect = new ReflectionClass($this);
		$classname = $reflect->getShortName();
		
		if($parent == 'CessionarioCommittente'){

			// Codice Fiscale
			if(isset($xmldata->CodiceFiscale) 
				&& $xmldata->CodiceFiscale instanceof SimpleXMLElement
				&& (string) $xmldata->CodiceFiscale != ''
			){
				
				$this->__set('CodiceFiscale', (string) $xmldata->CodiceFiscale);
			} else{

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
			}
		} else{
			
			// Id Fiscale IVA
			if(isset($xmldata->IdFiscaleIVA) 
				&& $xmldata->IdFiscaleIVA instanceof SimpleXMLElement
			){
				
				if($xmldata->IdFiscaleIVA->count() == 1){
					
					$this->__IdFiscaleIVA = $this->IdFiscaleIVA
						->loopXml($xmldata->IdFiscaleIVA);
				} else{
					
					$this->err()->setErrors(_('IdFiscale IVA: Il nodo deve essere presente una sola volta in '.$classname));
				}
			} else{
				
				$this->err()->setErrors(_('Id Fiscale IVA: Il tipo complesso è obbligatorio in '.$classname));
			}
	
			// Codice Fiscale
			if(isset($xmldata->CodiceFiscale) 
				&& $xmldata->CodiceFiscale instanceof SimpleXMLElement
				&& (string) $xmldata->CodiceFiscale != ''
			){
				
				$this->__set('CodiceFiscale', (string) $xmldata->CodiceFiscale);
			}
		}

		// Anagrafica
		if(isset($xmldata->Anagrafica) 
			&& $xmldata->Anagrafica instanceof SimpleXMLElement
		){
			
			if($xmldata->Anagrafica->count() == 1){
				
				$this->__Anagrafica = $this->Anagrafica
					->loopXml($xmldata->Anagrafica);
			} else{
				
				$this->err()->setErrors(_('Anagrafica: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Anagrafica: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		if($parent == 'CedentePrestatore'){
	
			// Albo Professionale
			if(isset($xmldata->AlboProfessionale) 
				&& $xmldata->AlboProfessionale instanceof SimpleXMLElement
				&& (string) $xmldata->AlboProfessionale != ''
			){
				
				$this->__set('AlboProfessionale', (string) $xmldata->AlboProfessionale);
			}
	
			// Provincia Albo
			if(isset($xmldata->ProvinciaAlbo) 
				&& $xmldata->ProvinciaAlbo instanceof SimpleXMLElement
				&& (string) $xmldata->ProvinciaAlbo != ''
			){
				
				$this->__set('ProvinciaAlbo', (string) $xmldata->ProvinciaAlbo);
			}
	
			// Numero Iscrizione Albo
			if(isset($xmldata->NumeroIscrizioneAlbo) 
				&& $xmldata->NumeroIscrizioneAlbo instanceof SimpleXMLElement
				&& (string) $xmldata->NumeroIscrizioneAlbo != ''
			){
				
				$this->__set('NumeroIscrizioneAlbo', (string) $xmldata->NumeroIscrizioneAlbo);
			}
	
			// Data Iscrizione Albo
			if(isset($xmldata->DataIscrizioneAlbo) 
				&& $xmldata->DataIscrizioneAlbo instanceof SimpleXMLElement
				&& (string) $xmldata->DataIscrizioneAlbo != ''
			){
				
				$this->__set('DataIscrizioneAlbo', (string) $xmldata->DataIscrizioneAlbo);
			}
	
			// Regime Fiscale
			if(isset($xmldata->RegimeFiscale) 
				&& $xmldata->RegimeFiscale instanceof SimpleXMLElement
				&& (string) $xmldata->RegimeFiscale != ''
			){
				
				$this->__set('RegimeFiscale', (string) $xmldata->RegimeFiscale);
			} else{
				
				$this->err()->setErrors(_('Regime Fiscale: Il tipo è obbligatorio in '.$classname));
			}
		}
				
		return $this;
	}
}