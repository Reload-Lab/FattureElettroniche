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

class FatturaElettronicaHeader extends Tag {
	
	/**
	 * Dati Trasmissione
	 * @var object type DatiTrasmissione
	 * @required yes
	 */
	protected $__DatiTrasmissione;
	
	/**
	 * Cedente Prestatore
	 * @var object type CedentePrestatore
	 * @required yes
	 */
	protected $__CedentePrestatore;
	
	/**
	 * Rappresentante Fiscale
	 * @var object type RappresentanteFiscale
	 * @required no
	 */
	protected $__RappresentanteFiscale;
	
	/**
	 * Cessionario Committente
	 * @var object type CessionarioCommittente
	 * @required yes
	 */
	protected $__CessionarioCommittente;
	
	/**
	 * Terzo Intermediario o Soggetto Emittente
	 * @var object type TerzoIntermediarioOSoggettoEmittente
	 * @required no
	 */
	protected $__TerzoIntermediarioOSoggettoEmittente;
	
	/**
	 * Soggetto Emittente
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required no
	 */
	protected $SoggettoEmittente;
	
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
				
				// Soggetto Emittente
				if($name == 'SoggettoEmittente'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$SE[$value])){
						
						$this->err()->setErrors(_('Soggetto Emittente "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.$classname));
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
		
		// Dati Trasmissione
		if($this->__DatiTrasmissione instanceof DatiTrasmissione){
			
			$child = $this->__DatiTrasmissione->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Dati Trasmissione: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Cedente Prestatore
		if($this->__CedentePrestatore instanceof CedentePrestatore){
			
			$child = $this->__CedentePrestatore->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Cedente Prestatore: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Rappresentante Fiscale
		if($this->__RappresentanteFiscale instanceof RappresentanteFiscale){
			
			$child = $this->__RappresentanteFiscale->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		}
		
		// Cessionario Committente
		if($this->__CessionarioCommittente instanceof CessionarioCommittente){
			
			$child = $this->__CessionarioCommittente->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Cessionario Committente: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Terzo Intermediario O Soggetto Emittente
		if($this->__TerzoIntermediarioOSoggettoEmittente instanceof TerzoIntermediarioOSoggettoEmittente){
			
			$child = $this->__TerzoIntermediarioOSoggettoEmittente->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		}
		
		// Soggetto Emittente
		if($this->SoggettoEmittente != ''){
			
			$child = parent::$_dom->createElement('SoggettoEmittente', $this->SoggettoEmittente);
			
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
		
		// Dati Trasmissione
		if(isset($xmldata->DatiTrasmissione) 
			&& $xmldata->DatiTrasmissione instanceof SimpleXMLElement
		){
			
			if($xmldata->DatiTrasmissione->count() == 1){
				
				$this->__DatiTrasmissione = $this->DatiTrasmissione
					->loopXml($xmldata->DatiTrasmissione);
			} else{
				
				$this->err()->setErrors(_('Dati Trasmissione: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Dati Trasmissione: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Cedente Prestatore
		if(isset($xmldata->CedentePrestatore) 
			&& $xmldata->CedentePrestatore instanceof SimpleXMLElement
		){
			
			if($xmldata->CedentePrestatore->count() == 1){
				
				$this->__CedentePrestatore = $this->CedentePrestatore
					->loopXml($xmldata->CedentePrestatore);
			} else{
				
				$this->err()->setErrors(_('Cedente Prestatore: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Cedente Prestatore: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Rappresentante Fiscale
		if(isset($xmldata->RappresentanteFiscale) 
			&& $xmldata->RappresentanteFiscale instanceof SimpleXMLElement
		){
			
			if($xmldata->RappresentanteFiscale->count() == 1){
				
				$this->__RappresentanteFiscale = $this->RappresentanteFiscale
					->loopXml($xmldata->RappresentanteFiscale);
			} else{
				
				$this->err()->setErrors(_('Rappresentante Fiscale: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}
		
		// Cessionario Committente
		if(isset($xmldata->CessionarioCommittente) 
			&& $xmldata->CessionarioCommittente instanceof SimpleXMLElement
		){
			
			if($xmldata->CessionarioCommittente->count() == 1){
				
				$this->__CessionarioCommittente = $this->CessionarioCommittente
					->loopXml($xmldata->CessionarioCommittente);
			} else{
				
				$this->err()->setErrors(_('Cessionario Committente: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Cessionario Committente: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Terzo Intermediario O Soggetto Emittente
		if(isset($xmldata->TerzoIntermediarioOSoggettoEmittente) 
			&& $xmldata->TerzoIntermediarioOSoggettoEmittente instanceof SimpleXMLElement
		){
			
			if($xmldata->TerzoIntermediarioOSoggettoEmittente->count() == 1){
				
				$this->__TerzoIntermediarioOSoggettoEmittente = $this->TerzoIntermediarioOSoggettoEmittente
					->loopXml($xmldata->TerzoIntermediarioOSoggettoEmittente);
			} else{
				
				$this->err()->setErrors(_('Terzo Intermediario O Soggetto Emittente: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}
		
		// Soggetto Emittente
		if(isset($xmldata->SoggettoEmittente) 
			&& $xmldata->SoggettoEmittente instanceof SimpleXMLElement
			&& (string) $xmldata->DatiTrasmissione != ''
		){
			
			$this->__set('SoggettoEmittente', (string) $xmldata->SoggettoEmittente);
		}
		
		return $this;
	}
}
