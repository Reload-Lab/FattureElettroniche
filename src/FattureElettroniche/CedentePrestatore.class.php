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

class CedentePrestatore extends Tag {
	
	/**
	 * Dati Anagrafici
	 * @var object type DatiAnagrafici
	 * @required yes
	 */
	protected $__DatiAnagrafici;
	
	/**
	 * Sede
	 * @var object type Sede
	 * @required yes
	 */
	protected $__Sede;
	
	/**
	 * Stabile Organizzazione
	 * @var object type StabileOrganizzazione
	 * @required no
	 */
	protected $__StabileOrganizzazione;
	
	/**
	 * Iscrizione REA
	 * @var object type IscrizioneREA
	 * @required no
	 */
	protected $__IscrizioneREA;
	
	/**
	 * Contatti
	 * @var object type Contatti
	 * @required no
	 */
	protected $__Contatti;
	
	/**
	 * Riferimento Amministrazione
	 * Formato alfanumerico; lunghezza massima di 20 caratteri
	 * @var string
	 * @required no
	 */
	protected $RiferimentoAmministrazione;
	
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
				
				// Riferimento Amministrazione
				if($name == 'RiferimentoAmministrazione'){
					
					if(!is_string($value) 
						|| strlen($value) > 20
					){
						
						$this->err()->setErrors(_('Riferimento Amministrazione "'.$value.'": Formato alfanumerico; lunghezza massima di 20 caratteri in '.$classname));
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
		
		// Dati Anagrafici
		if($this->__DatiAnagrafici instanceof DatiAnagrafici){
			
			$child = $this->__DatiAnagrafici->getXml('CedentePrestatore');
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Dati Anagrafici: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Sede
		if($this->__Sede instanceof Sede){
			
			$child = $this->__Sede->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Sede: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Stabile Organizzazione
		if($this->__StabileOrganizzazione instanceof StabileOrganizzazione){
			
			$child = $this->__StabileOrganizzazione->getXml();
			
			if($child instanceof DOMNode){
				
				$elem->appendChild($child);
			}
		}
		
		// Iscrizione REA
		if($this->__IscrizioneREA instanceof IscrizioneREA){
			
			$child = $this->__IscrizioneREA->getXml();
			
			if($child instanceof DOMNode){
				
				$elem->appendChild($child);
			}
		}
		
		// Contatti
		if($this->__Contatti instanceof Contatti){
			
			$child = $this->__Contatti->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		}
		
		// Riferimento Amministrazione
		if($this->RiferimentoAmministrazione != ''){
			
			$child = parent::$_dom->createElement('RiferimentoAmministrazione', $this->RiferimentoAmministrazione);
			
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
		
		// Dati Anagrafici
		if(isset($xmldata->DatiAnagrafici) 
			&& $xmldata->DatiAnagrafici instanceof SimpleXMLElement
		){

			if($xmldata->DatiAnagrafici->count() == 1){
				
				$this->__DatiAnagrafici = $this->DatiAnagrafici
					->loopXml($xmldata->DatiAnagrafici, 'CedentePrestatore');
			} else{
				
				$this->err()->setErrors(_('Dati Anagrafici: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Dati Anagrafici: Il tipo complesso è obbligatorio in '.$classname));
		}

		// Sede
		if(isset($xmldata->Sede) 
			&& $xmldata->Sede instanceof SimpleXMLElement
		){
			
			if($xmldata->Sede->count() == 1){
				
				$this->__Sede = $this->Sede
					->loopXml($xmldata->Sede);
			} else{
				
				$this->err()->setErrors(_('Sede: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Sede: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Stabile Organizzazione
		if(isset($xmldata->StabileOrganizzazione) 
			&& $xmldata->StabileOrganizzazione instanceof SimpleXMLElement
		){
			
			if($xmldata->StabileOrganizzazione->count() == 1){
				
				$this->__StabileOrganizzazione = $this->StabileOrganizzazione
					->loopXml($xmldata->StabileOrganizzazione);
			} else{
				
				$this->err()->setErrors(_('Stabile Organizzazione: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}
		
		// Iscrizione REA
		if(isset($xmldata->IscrizioneREA) 
			&& $xmldata->IscrizioneREA instanceof SimpleXMLElement
		){
			
			if($xmldata->IscrizioneREA->count() == 1){
				
				$this->__IscrizioneREA = $this->IscrizioneREA
					->loopXml($xmldata->IscrizioneREA);
			} else{
				
				$this->err()->setErrors(_('Iscrizione REA: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}
		
		// Contatti
		if(isset($xmldata->Contatti) 
			&& $xmldata->Contatti instanceof SimpleXMLElement
		){
			
			if($xmldata->Contatti->count() == 1){
				
				$this->__Contatti = $this->Contatti
					->loopXml($xmldata->Contatti);
			} else{
				
				$this->err()->setErrors(_('Contatti: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}

		// Riferimento Amministrazione
		if(isset($xmldata->RiferimentoAmministrazione) 
			&& $xmldata->RiferimentoAmministrazione instanceof SimpleXMLElement
			&& (string) $xmldata->RiferimentoAmministrazione != ''
		){
			
			$this->__set('RiferimentoAmministrazione', (string) $xmldata->RiferimentoAmministrazione);
		}
		
		return $this;
	}
}