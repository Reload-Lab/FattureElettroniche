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
use \SimpleXMLElement;
use \DOMNode;

class RappresentanteFiscale extends Tag {
	
	/**
	 * Dati Anagrafici
	 * @var object type DatiAnagrafici
	 * @required yes
	 */
	protected $__DatiAnagrafici;
	
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
			
			$child = $this->__DatiAnagrafici->getXml();
			
			if($child instanceof DOMNode){
				
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Dati Anagrafici: Il tipo complesso è obbligatorio in '.$classname));
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
					->loopXml($xmldata->DatiAnagrafici);
			} else{
				
				$this->err()->setErrors(_('Dati Anagrafici: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Dati Anagrafici: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}