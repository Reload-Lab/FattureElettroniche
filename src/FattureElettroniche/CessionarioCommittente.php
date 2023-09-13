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
use \SimpleXMLElement;
use \DOMNode;

class CessionarioCommittente extends Tag {
	
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
	 * Rappresentante Fiscale Cessionario
	 * @var object type RappresentanteFiscaleCessionario
	 * @required no
	 */
	protected $__RappresentanteFiscaleCessionario;
	
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
			
			$child = $this->__DatiAnagrafici->getXml('CessionarioCommittente');
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Dati Anagrafici: Il tipo complesso è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Sede
		if($this->__Sede instanceof Sede){
			
			$child = $this->__Sede->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Sede: Il tipo complesso è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Stabile Organizzazione
		if($this->__StabileOrganizzazione instanceof StabileOrganizzazione){
			
			$child = $this->__StabileOrganizzazione->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		}
		
		// Rappresentante Fiscale Cessionario
		if($this->__RappresentanteFiscaleCessionario instanceof RappresentanteFiscaleCessionario){
			
			$child = $this->__RappresentanteFiscaleCessionario->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
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
		
		// Dati Anagrafici
		if(isset($xmldata->DatiAnagrafici) 
			&& $xmldata->DatiAnagrafici instanceof SimpleXMLElement
		){
			if($xmldata->DatiAnagrafici->count() == 1){
				
				$this->__DatiAnagrafici = $this->DatiAnagrafici
					->loopXml($xmldata->DatiAnagrafici, 'CessionarioCommittente');
			} else{
				
				$this->err()->setErrors(_('Dati Anagrafici: Il nodo deve essere presente una sola volta in '.__FILE__.' on line '.__LINE__));
			}
		} else{
			
			$this->err()->setErrors(_('Dati Anagrafici: Il tipo complesso è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}

		// Sede
		if(isset($xmldata->Sede) 
			&& $xmldata->Sede instanceof SimpleXMLElement
		){
			if($xmldata->Sede->count() == 1){
				
				$this->__Sede = $this->Sede
					->loopXml($xmldata->Sede);
			} else{
				
				$this->err()->setErrors(_('Sede: Il nodo deve essere presente una sola volta in '.__FILE__.' on line '.__LINE__));
			}
		} else{
			
			$this->err()->setErrors(_('Sede: Il tipo complesso è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Stabile Organizzazione
		if(isset($xmldata->StabileOrganizzazione) 
			&& $xmldata->StabileOrganizzazione instanceof SimpleXMLElement
		){
			if($xmldata->StabileOrganizzazione->count() == 1){
				
				$this->__StabileOrganizzazione = $this->StabileOrganizzazione
					->loopXml($xmldata->StabileOrganizzazione);
			} else{
				
				$this->err()->setErrors(_('Stabile Organizzazione: Il nodo deve essere presente una sola volta in '.__FILE__.' on line '.__LINE__));
			}
		}
		
		// Rappresentante Fiscale Cessionario
		if(isset($xmldata->RappresentanteFiscale) 
			&& $xmldata->RappresentanteFiscale instanceof SimpleXMLElement
		){
			if($xmldata->RappresentanteFiscale->count() == 1){
				
				$this->__RappresentanteFiscaleCessionario = $this->RappresentanteFiscaleCessionario
					->loopXml($xmldata->RappresentanteFiscale);
			} else{
				
				$this->err()->setErrors(_('Rappresentante Fiscale: Il nodo deve essere presente una sola volta in '.__FILE__.' on line '.__LINE__));
			}
		}
		
		return $this;
	}
}
