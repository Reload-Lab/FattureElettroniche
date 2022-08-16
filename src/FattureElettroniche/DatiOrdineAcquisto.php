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
use \ArrayAccess;

class DatiOrdineAcquisto extends Tag implements ArrayAccess {
	
	use OffsetArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Riferimento Numero Linea
	 * @var object type RiferimentoNumeroLinea
	 * @required no
	 */
	protected $__RiferimentoNumeroLinea;
	
	/**
	 * Id Documento
	 * Formato alfanumerico; lunghezza massima di 20 caratteri
	 * @var string
	 * @required yes
	 */
	protected $IdDocumento;
	
	/**
	 * Data
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required no
	 */
	protected $Data;
	
	/**
	 * Num Item
	 * Formato alfanumerico; lunghezza massima di 20 caratteri
	 * @var string
	 * @required no
	 */
	protected $NumItem;
	
	/**
	 * Codice Commessa Convenzione
	 * Formato alfanumerico; lunghezza massima di 100 caratteri
	 * @var string
	 * @required no
	 */
	protected $CodiceCommessaConvenzione;
	
	/**
	 * Codice CUP
	 * Formato alfanumerico; lunghezza massima di 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $CodiceCUP;
	
	/**
	 * Codice CIG
	 * Formato alfanumerico; lunghezza massima di 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $CodiceCIG;
	
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
				
				// Id Documento
				if($name == 'IdDocumento'){
					
					if(!is_string($value) 
						|| strlen($value) > 20
					){
						
						$this->err()->setErrors(_('Id Documento "'.$value.'": Formato alfanumerico; lunghezza massima di 20 caratteri in '.$classname));
						return;
					}
				}
				
				// Data
				if($name == 'Data'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						
						$this->err()->setErrors(_('Data "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.$classname));
						return;
					}
				}
				
				// Num Item
				if($name == 'NumItem'){
					
					if(!is_string($value) 
						|| strlen($value) > 20
					){
						
						$this->err()->setErrors(_('Num Item "'.$value.'": Formato alfanumerico; lunghezza massima di 20 caratteri in '.$classname));
						return;
					}
				}
				
				// Codice Commessa Convenzione
				if($name == 'CodiceCommessaConvenzione'){
					
					if(!is_string($value) 
						|| strlen($value) > 100
					){
						
						$this->err()->setErrors(_('Codice Commessa Convenzione "'.$value.'": Formato alfanumerico; lunghezza massima di 100 caratteri in '.$classname));
						return;
					}
				}
				
				// Codice CUP
				if($name == 'CodiceCUP'){
					
					if(!is_string($value) 
						|| strlen($value) > 15
					){
						
						$this->err()->setErrors(_('Codice CUP "'.$value.'": Formato alfanumerico; lunghezza massima di 15 caratteri in '.$classname));
						return;
					}
				}
				
				// Codice CIG
				if($name == 'CodiceCIG'){
					
					if(!is_string($value) 
						|| strlen($value) > 15
					){
						
						$this->err()->setErrors(_('Codice CIG "'.$value.'": Formato alfanumerico; lunghezza massima di 15 caratteri in '.$classname));
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
				
				// Riferimento Numero Linea
				if($var->__RiferimentoNumeroLinea instanceof RiferimentoNumeroLinea){
					
					$childs = $var->__RiferimentoNumeroLinea->getXml();
					
					if(count($childs)){
						
						foreach($childs as $var2){
							
							if($var2 instanceof DOMNode){
	
								$elem->appendChild($var2);
							}
						}
					}
				}
				
				// Id Documento
				if($var->IdDocumento != ''){
					
					$child = parent::$_dom->createElement('IdDocumento', $var->IdDocumento);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Id Documento: Il tipo è obbligatorio in '.$classname));
				}
				
				// Data
				if($var->Data != ''){
					
					$child = parent::$_dom->createElement('Data', $var->Data);
					
					$elem->appendChild($child);
				}
				
				// Num Item
				if($var->NumItem != ''){
					
					$child = parent::$_dom->createElement('NumItem', $var->NumItem);
					
					$elem->appendChild($child);
				}
				
				// Codice Commessa Convenzione
				if($var->CodiceCommessaConvenzione != ''){
					
					$child = parent::$_dom->createElement('CodiceCommessaConvenzione', $var->CodiceCommessaConvenzione);
					
					$elem->appendChild($child);
				}
				
				// Codice CUP
				if($var->CodiceCUP != ''){
					
					$child = parent::$_dom->createElement('CodiceCUP', $var->CodiceCUP);
					
					$elem->appendChild($child);
				}
				
				// Codice CIG
				if($var->CodiceCIG != ''){
					
					$child = parent::$_dom->createElement('CodiceCIG', $var->CodiceCIG);
					
					$elem->appendChild($child);
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
		
		// Riferimento Numero Linea
		if(isset($xmldata->RiferimentoNumeroLinea)
			&& $xmldata->RiferimentoNumeroLinea instanceof SimpleXMLElement
		){
			
			if($xmldata->RiferimentoNumeroLinea->count() > 1){
				
				for($k = 0; $k < $xmldata->RiferimentoNumeroLinea->count(); $k++){
					
					$this->__RiferimentoNumeroLinea[$k] = (string) $xmldata->RiferimentoNumeroLinea[$k];
				}
			} elseif($xmldata->RiferimentoNumeroLinea->count() == 1){
				
				$this->__RiferimentoNumeroLinea[0] = (string) $xmldata->RiferimentoNumeroLinea;
			}
		}
		
		// Id Documento
		if(isset($xmldata->IdDocumento) 
			&& $xmldata->IdDocumento instanceof SimpleXMLElement
			&& (string) $xmldata->IdDocumento != ''
		){
			
			$this->__set('IdDocumento', (string) $xmldata->IdDocumento);
		} else{
			
			$this->err()->setErrors(_('Id Documento: Il tipo è obbligatorio in '.$classname));
		}
		
		// Data
		if(isset($xmldata->Data) 
			&& $xmldata->Data instanceof SimpleXMLElement
			&& (string) $xmldata->Data != ''
		){
			
			$this->__set('Data', (string) $xmldata->Data);
		}
		
		// Num Item
		if(isset($xmldata->NumItem) 
			&& $xmldata->NumItem instanceof SimpleXMLElement
			&& (string) $xmldata->NumItem != ''
		){
			
			$this->__set('NumItem', (string) $xmldata->NumItem);
		}
		
		// Codice Commessa Convenzione
		if(isset($xmldata->CodiceCommessaConvenzione) 
			&& $xmldata->CodiceCommessaConvenzione instanceof SimpleXMLElement
			&& (string) $xmldata->CodiceCommessaConvenzione != ''
		){
			
			$this->__set('CodiceCommessaConvenzione', (string) $xmldata->CodiceCommessaConvenzione);
		}
		
		// Codice CUP
		if(isset($xmldata->CodiceCUP) 
			&& $xmldata->CodiceCUP instanceof SimpleXMLElement
			&& (string) $xmldata->CodiceCUP != ''
		){
			
			$this->__set('CodiceCUP', (string) $xmldata->CodiceCUP);
		}
		
		// Codice CIG
		if(isset($xmldata->CodiceCIG) 
			&& $xmldata->CodiceCIG instanceof SimpleXMLElement
			&& (string) $xmldata->CodiceCIG != ''
		){
			
			$this->__set('CodiceCIG', (string) $xmldata->CodiceCIG);
		}
		
		return $this;
	}
}