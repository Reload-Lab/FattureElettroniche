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
use \SimpleXMLElement;
use \DOMNode;

class FatturaElettronica extends Tag {
	
	/**
	 * Fattura Elettronica Header
	 * @var object type FatturaElettronicaHeader
	 * @required yes
	 */
	protected $__FatturaElettronicaHeader;
	
	/**
	 * Fattura Elettronica Body
	 * @var object type FatturaElettronicaBody
	 * @required yes
	 */
	protected $__FatturaElettronicaBody;
	
	/**
	 * Restituisce gli elementi relativi a questo oggetto 
	 * e agli oggetti sotto di lui
	 *
	 * @param string $filename
	 *
	 * @return string
	 */
	public function getXml($filename = null)
	{
		$reflect = new ReflectionClass($this);
		$classname = $reflect->getShortName();
		
		$this->createXML();
		
		$elem = self::$_dom->createElementNS('http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2', 'p:'.$classname);
		$elem->setAttribute('versione', 'FPR12');
		$elem->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
		$elem->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
		
		// Fattura Elettronica Header
		if($this->__FatturaElettronicaHeader instanceof FatturaElettronicaHeader){
			
			$child = $this->__FatturaElettronicaHeader->getXml();
			
			if($child instanceof DOMNode){

				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Fattura Elettronica Header: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Fattura Elettronica Body
		if($this->__FatturaElettronicaBody instanceof FatturaElettronicaBody){
			
			$childs = $this->__FatturaElettronicaBody->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
						
						$elem->appendChild($var);
					}
				}
			} else{
				
				$this->err()->setErrors(_('Fattura Elettronica Body: Il tipo complesso è obbligatorio in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Fattura Elettronica Body: Il tipo complesso è obbligatorio in '.$classname));
		}

		if($this->thr()){
			
			self::$_dom->appendChild($elem);
			
			return $this->saveXML($filename);
		}
	}
	
	/**
	 * Prende una fattura xml e genera la struttura
	 *
	 * @return null
	 */
	public function loadXml($filename)
	{
		$inst = false;
		
		if($xmldata = simplexml_load_file($filename)){
			
			$inst = new FatturaElettronica();
			
			$inst = $this->loopXml($xmldata);
		} else{
			
			$this->err()->setErrors(_('Impossibile leggere il file '.$filename));
		}
		
		$this->thr();
		
		return $inst;
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
		
		// Fattura Elettronica Header
		if(isset($xmldata->FatturaElettronicaHeader) 
			&& $xmldata->FatturaElettronicaHeader instanceof SimpleXMLElement
		){
			
			if($xmldata->FatturaElettronicaHeader->count() == 1){
				
				$this->__FatturaElettronicaHeader = $this->FatturaElettronicaHeader
					->loopXml($xmldata->FatturaElettronicaHeader);
			} else{
				
				$this->err()->setErrors(_('Fattura Elettronica Header: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Fattura Elettronica Header: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Fattura Elettronica Body
		if(isset($xmldata->FatturaElettronicaBody)
			&& $xmldata->FatturaElettronicaBody instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->FatturaElettronicaBody->count(); $k++){
				
				$this->__FatturaElettronicaBody[$k] = $this->FatturaElettronicaBody[$k]
					->loopXml($xmldata->FatturaElettronicaBody[$k]);
			}
		} else{
			
			$this->err()->setErrors(_('Fattura Elettronica Body: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}