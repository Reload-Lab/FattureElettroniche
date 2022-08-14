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

class DatiGenerali extends Tag {
	
	/**
	 * Dati Generali Documento
	 * @var object type DatiGeneraliDocumento
	 * @required yes
	 */
	protected $__DatiGeneraliDocumento;
	
	/**
	 * Dati Ordine Acquisto
	 * @var object type DatiOrdineAcquisto
	 * @required no
	 */
	protected $__DatiOrdineAcquisto;
	
	/**
	 * Dati Contratto
	 * @var object type DatiContratto
	 * @required no
	 */
	protected $__DatiContratto;
	
	/**
	 * Dati Convenzione
	 * @var object type DatiConvenzione
	 * @required no
	 */
	protected $__DatiConvenzione;
	
	/**
	 * Dati Ricezione
	 * @var object type DatiRicezione
	 * @required no
	 */
	protected $__DatiRicezione;
	
	/**
	 * Dati Fatture Collegate
	 * @var object type DatiFattureCollegate
	 * @required no
	 */
	protected $__DatiFattureCollegate;
	
	/**
	 * Dati SAL
	 * @var object type DatiSAL
	 * @required no
	 */
	protected $__DatiSAL;
	
	/**
	 * Dati DDT
	 * @var object type DatiDDT
	 * @required no
	 */
	protected $__DatiDDT;
	
	/**
	 * Dati Trasporto
	 * @var object type DatiTrasporto
	 * @required no
	 */
	protected $__DatiTrasporto;
	
	/**
	 * Fattura Principale
	 * @var object type FatturaPrincipale
	 * @required no
	 */
	protected $__FatturaPrincipale;
	
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
		
		// Dati Generali Documento
		if($this->__DatiGeneraliDocumento instanceof DatiGeneraliDocumento){
			
			$child = $this->__DatiGeneraliDocumento->getXml();
			
			if($child instanceof DOMNode){
				
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Dati Generali Documento: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Dati Ordine Acquisto
		if($this->__DatiOrdineAcquisto instanceof DatiOrdineAcquisto){
			
			$childs = $this->__DatiOrdineAcquisto->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
						
						$elem->appendChild($var);
					}
				}
			}
		}
		
		// Dati Contratto
		if($this->__DatiContratto instanceof DatiContratto){
			
			$childs = $this->__DatiContratto->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
						
						$elem->appendChild($var);
					}
				}
			}
		}
		
		// Dati Convenzione
		if($this->__DatiConvenzione instanceof DatiConvenzione){
			
			$childs = $this->__DatiConvenzione->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
	
						$elem->appendChild($var);
					}
				}
			}
		}
		
		// Dati Ricezione
		if($this->__DatiRicezione instanceof DatiRicezione){
			
			$childs = $this->__DatiRicezione->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
	
						$elem->appendChild($var);
					}
				}
			}
		}
		
		// Dati Fatture Collegate
		if($this->__DatiFattureCollegate instanceof DatiFattureCollegate){
			
			$childs = $this->__DatiFattureCollegate->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
	
						$elem->appendChild($var);
					}
				}
			}
		}
		
		// Dati SAL
		if($this->__DatiSAL instanceof DatiSAL){
			
			$child = $this->__DatiSAL->getXml();
			
			if($child instanceof DOMNode){
				
				$elem->appendChild($child);
			}
		}
		
		// Dati DDT
		if($this->__DatiDDT instanceof DatiDDT){
			
			$childs = $this->__DatiDDT->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
	
						$elem->appendChild($var);
					}
				}
			}
		}
		
		// Dati Trasporto
		if($this->__DatiTrasporto instanceof DatiTrasporto){
			
			$child = $this->__DatiTrasporto->getXml();
			
			if($child instanceof DOMNode){
				
				$elem->appendChild($child);
			}
		}
		
		// Fattura Principale
		if($this->__FatturaPrincipale instanceof FatturaPrincipale){
			
			$child = $this->__FatturaPrincipale->getXml();
			
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
		
		// Dati Generali Documento
		if(isset($xmldata->DatiGeneraliDocumento) 
			&& $xmldata->DatiGeneraliDocumento instanceof SimpleXMLElement
		){
			
			if($xmldata->DatiGeneraliDocumento->count() == 1){
				
				$this->__DatiGeneraliDocumento = $this->DatiGeneraliDocumento
					->loopXml($xmldata->DatiGeneraliDocumento);
			} else{
				
				$this->err()->setErrors(_('Dati Generali Documento: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Dati Generali Documento: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Dati Ordine Acquisto
		if(isset($xmldata->DatiOrdineAcquisto)
			&& $xmldata->DatiOrdineAcquisto instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->DatiOrdineAcquisto->count(); $k++){
				
				$this->__DatiOrdineAcquisto[$k] = $this->DatiOrdineAcquisto[$k]
					->loopXml($xmldata->DatiOrdineAcquisto[$k]);
			}
		}
		
		// Dati Contratto
		if(isset($xmldata->DatiContratto)
			&& $xmldata->DatiContratto instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->DatiContratto->count(); $k++){
				
				$this->__DatiContratto[$k] = $this->DatiContratto[$k]
					->loopXml($xmldata->DatiContratto[$k]);
			}
		}
		
		// Dati Convenzione
		if(isset($xmldata->DatiConvenzione)
			&& $xmldata->DatiConvenzione instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->DatiConvenzione->count(); $k++){
				
				$this->__DatiConvenzione[$k] = $this->DatiConvenzione[$k]
					->loopXml($xmldata->DatiConvenzione[$k]);
			}
		}
		
		// Dati Ricezione
		if(isset($xmldata->DatiRicezione)
			&& $xmldata->DatiRicezione instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->DatiRicezione->count(); $k++){
				
				$this->__DatiRicezione[$k] = $this->DatiRicezione[$k]
					->loopXml($xmldata->DatiRicezione[$k]);
			}
		}
		
		// Dati Fatture Collegate
		if(isset($xmldata->DatiFattureCollegate)
			&& $xmldata->DatiFattureCollegate instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->DatiFattureCollegate->count(); $k++){
				
				$this->__DatiFattureCollegate[$k] = $this->DatiFattureCollegate[$k]
					->loopXml($xmldata->DatiFattureCollegate[$k]);
			}
		}
		
		// Dati SAL
		if(isset($xmldata->DatiSAL) 
			&& $xmldata->DatiSAL instanceof SimpleXMLElement
		){
			
			if($xmldata->DatiSAL->count() == 1){
				
				$this->__DatiSAL = $this->DatiSAL
					->loopXml($xmldata->DatiSAL);
			} else{
				
				$this->err()->setErrors(_('Dati SAL: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}
		
		// Dati DDT
		if(isset($xmldata->DatiDDT)
			&& $xmldata->DatiDDT instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->DatiDDT->count(); $k++){
				
				$this->__DatiDDT[$k] = $this->DatiDDT[$k]
					->loopXml($xmldata->DatiDDT[$k]);
			}
		}
		
		// Dati Trasporto
		if(isset($xmldata->DatiTrasporto) 
			&& $xmldata->DatiTrasporto instanceof SimpleXMLElement
		){
			
			if($xmldata->DatiTrasporto->count() == 1){
				
				$this->__DatiTrasporto = $this->DatiTrasporto
					->loopXml($xmldata->DatiTrasporto);
			} else{
				
				$this->err()->setErrors(_('Dati Trasporto: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}
		
		// Fattura Principale
		if(isset($xmldata->FatturaPrincipale) 
			&& $xmldata->FatturaPrincipale instanceof SimpleXMLElement
		){
			
			if($xmldata->FatturaPrincipale->count() == 1){
				
				$this->__FatturaPrincipale = $this->FatturaPrincipale
					->loopXml($xmldata->FatturaPrincipale);
			} else{
				
				$this->err()->setErrors(_('Fattura Principale: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}
		
		return $this;
	}
}