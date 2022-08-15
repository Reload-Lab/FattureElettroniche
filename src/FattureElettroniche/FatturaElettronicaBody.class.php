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
use \ArrayAccess;

class FatturaElettronicaBody extends Tag implements ArrayAccess {
	
	use OffsetArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Dati Generali
	 * @var object type DatiGenerali
	 * @required yes
	 */
	protected $__DatiGenerali;
	
	/**
	 * Dati Beni Servizi
	 * @var object type DatiBeniServizi
	 * @required yes
	 */
	protected $__DatiBeniServizi;
	
	/**
	 * Dati Veicoli
	 * @var object type DatiVeicoli
	 * @required no
	 */
	protected $__DatiVeicoli;
	
	/**
	 * Dati Pagamento
	 * @var object type DatiPagamento
	 * @required no
	 */
	protected $__DatiPagamento;
	
	/**
	 * Allegati
	 * @var object type Allegati
	 * @required no
	 */
	protected $__Allegati;
	
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

		$arr = array();
		
		if(count($this->_instances)){
			
			foreach($this->_instances as $var){
				
				$elem = parent::$_dom->createElement($classname);
				
				// Dati Generali
				if($var->__DatiGenerali instanceof DatiGenerali){
					
					$child = $var->__DatiGenerali->getXml();
					
					if($child instanceof DOMNode){
	
						$elem->appendChild($child);
					}
				} else{
					
					$this->err()->setErrors(_('Dati Generali: Il tipo complesso è obbligatorio in '.$classname));
				}
				
				// Dati Beni Servizi
				if($var->__DatiBeniServizi instanceof DatiBeniServizi){
					
					$child = $var->__DatiBeniServizi->getXml();
					
					if($child instanceof DOMNode){
	
						$elem->appendChild($child);
					}
				} else{
					
					$this->err()->setErrors(_('Dati Beni Servizi: Il tipo complesso è obbligatorio in '.$classname));
				}
				
				// Dati Veicoli
				if($var->__DatiVeicoli instanceof DatiVeicoli){
					
					$child = $var->__DatiVeicoli->getXml();
					
					if($child instanceof DOMNode){
	
						$elem->appendChild($child);
					}
				}
				
				// Dati Pagamento
				if($var->__DatiPagamento instanceof DatiPagamento){
					
					$childs = $var->__DatiPagamento->getXml();
					
					if(count($childs)){
						
						foreach($childs as $var2){
							
							if($var2 instanceof DOMNode){
	
								$elem->appendChild($var2);
							}
						}
					}
				}
				
				// Allegati
				if($var->__Allegati instanceof Allegati){
					
					$childs = $var->__Allegati->getXml();
					
					if(count($childs)){
						
						foreach($childs as $var2){
							
							if($var2 instanceof DOMNode){
	
								$elem->appendChild($var2);
							}
						}
					}
				}
				
				array_push($arr, $elem);
			}
		}
		
		return $arr;
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
		
		// Dati Generali
		if(isset($xmldata->DatiGenerali) 
			&& $xmldata->DatiGenerali instanceof SimpleXMLElement
		){
			
			if($xmldata->DatiGenerali->count() == 1){
				
				$this->__DatiGenerali = $this->DatiGenerali
					->loopXml($xmldata->DatiGenerali);
			} else{
				
				$this->err()->setErrors(_('Dati Generali: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Dati Generali: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Dati Beni Servizi
		if(isset($xmldata->DatiBeniServizi) 
			&& $xmldata->DatiBeniServizi instanceof SimpleXMLElement
		){
			
			if($xmldata->DatiBeniServizi->count() == 1){
				
				$this->__DatiBeniServizi = $this->DatiBeniServizi
					->loopXml($xmldata->DatiBeniServizi);
			} else{
				
				$this->err()->setErrors(_('Dati Beni Servizi: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Dati Beni Servizi: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Dati Veicoli
		if(isset($xmldata->DatiVeicoli) 
			&& $xmldata->DatiVeicoli instanceof SimpleXMLElement
		){
			
			if($xmldata->DatiVeicoli->count() == 1){
				
				$this->__DatiVeicoli = $this->DatiVeicoli
					->loopXml($xmldata->DatiVeicoli);
			} else{
				
				$this->err()->setErrors(_('Dati Veicoli: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}
		
		// Dati Pagamento
		if(isset($xmldata->DatiPagamento)
			&& $xmldata->DatiPagamento instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->DatiPagamento->count(); $k++){
				
				$inst->__DatiPagamento[$k] = $this->DatiPagamento[$k]
					->loopXml($xmldata->DatiPagamento[$k]);
			}
		}
		
		// Allegati
		if(isset($xmldata->Allegati)
			&& $xmldata->Allegati instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->Allegati->count(); $k++){
				
				$inst->__Allegati[$k] = $this->Allegati[$k]
					->loopXml($xmldata->Allegati[$k]);
			}
		}
		
		return $this;
	}
}
