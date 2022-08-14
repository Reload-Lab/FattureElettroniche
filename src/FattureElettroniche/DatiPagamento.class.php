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
use \ReflectionProperty;
use \SimpleXMLElement;
use \DOMNode;
use \ArrayAccess;

class DatiPagamento extends Tag implements ArrayAccess {
	
	use OffsetArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Condizioni Pagamento
	 * Formato alfanumerico; lunghezza di 4 caratteri
	 * @var string
	 * @required yes
	 */
	protected $CondizioniPagamento;
	
	/**
	 * Dettaglio Pagamento
	 * @var object type DettaglioPagamento
	 * @required yes
	 */
	protected $__DettaglioPagamento;
	
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
				
				// Condizioni Pagamento
				if($name == 'CondizioniPagamento'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$CP[$value])){
						
						$this->err()->setErrors(_('Condizioni Pagamento "'.$value.'": Formato alfanumerico; lunghezza di 4 caratteri in '.$classname));
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

		$arr = array();
		
		if(count($this->_instances)){
			
			foreach($this->_instances as $var){
				
				$elem = parent::$_dom->createElement($classname);
				
				// Condizioni Pagamento
				if($var->CondizioniPagamento != ''){
					
					$child = parent::$_dom->createElement('CondizioniPagamento', $var->CondizioniPagamento);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Condizioni Pagamento: Il tipo è obbligatorio in '.$classname));
				}
				
				// Dettaglio Pagamento
				if($var->__DettaglioPagamento instanceof DettaglioPagamento){
					
					$childs = $var->__DettaglioPagamento->getXml();
					
					if(count($childs)){
						
						foreach($childs as $var2){
							
							if($var2 instanceof DOMNode){
	
								$elem->appendChild($var2);
							}
						}
					} else{
						
						$this->err()->setErrors(_('Dettaglio Pagamento: Il tipo complesso è obbligatorio in '.$classname));
					}
				} else{
					
					$this->err()->setErrors(_('Dettaglio Pagamento: Il tipo complesso è obbligatorio in '.$classname));
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
		
		// Condizioni Pagamento
		if(isset($xmldata->CondizioniPagamento) 
			&& $xmldata->CondizioniPagamento instanceof SimpleXMLElement
			&& (string) $xmldata->CondizioniPagamento != ''
		){
			
			$this->__set('CondizioniPagamento', (string) $xmldata->CondizioniPagamento);
		} else{
			
			$this->err()->setErrors(_('Condizioni Pagamento: Il tipo è obbligatorio in '.$classname));
		}
		
		// Dettaglio Pagamento
		if(isset($xmldata->DettaglioPagamento)
			&& $xmldata->DettaglioPagamento instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->DettaglioPagamento->count(); $k++){
				
				$this->__DettaglioPagamento[$k] = $this->DettaglioPagamento[$k]
					->loopXml($xmldata->DettaglioPagamento[$k]);
			}
		} else{
			
			$this->err()->setErrors(_('Dettaglio Pagamento: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}