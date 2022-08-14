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

class DatiBeniServizi extends Tag {
	
	/**
	 * Dettaglio Linee
	 * @var object type DettaglioLinee
	 * @required yes
	 */
	protected $__DettaglioLinee;
	
	/**
	 * Dati Riepilogo
	 * @var object type DatiRiepilogo
	 * @required yes
	 */
	protected $__DatiRiepilogo;
	
	/**
	 * Restituisce gli elementi relativi a questo oggetto 
	 * e agli oggetti sotto di lui
	 *
	 * @return array
	 */
	public function getXml()
	{
		$reflect = new ReflectionClass($this);
		$classname = $reflect->getShortName();
		
		$elem = parent::$_dom->createElement($classname);
		
		// Dettaglio Linee
		if($this->__DettaglioLinee instanceof DettaglioLinee){
			
			$childs = $this->__DettaglioLinee->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
						
						$elem->appendChild($var);
					}
				}
			} else{
				
				$this->err()->setErrors(_('Dettaglio Linee: Il tipo complesso è obbligatorio in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Dettaglio Linee: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Dati Riepilogo
		if($this->__DatiRiepilogo instanceof DatiRiepilogo){
			
			$childs = $this->__DatiRiepilogo->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
						
						$elem->appendChild($var);
					}
				}
			} else{
				
				$this->err()->setErrors(_('Dati Riepilogo: Il tipo complesso è obbligatorio in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Dati Riepilogo: Il tipo complesso è obbligatorio in '.$classname));
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
		
		// Dettaglio Linee
		if(isset($xmldata->DettaglioLinee)
			&& $xmldata->DettaglioLinee instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->DettaglioLinee->count(); $k++){

				$this->__DettaglioLinee[$k] = $this->DettaglioLinee[$k]
					->loopXml($xmldata->DettaglioLinee[$k]);
			}
		} else{
			
			$this->err()->setErrors(_('Dettaglio Linee: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Dati Riepilogo
		if(isset($xmldata->DatiRiepilogo)
			&& $xmldata->DatiRiepilogo instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->DatiRiepilogo->count(); $k++){
				
				$this->__DatiRiepilogo[$k] = $this->DatiRiepilogo[$k]
					->loopXml($xmldata->DatiRiepilogo[$k]);
			}
		} else{
			
			$this->err()->setErrors(_('Dati Riepilogo: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}