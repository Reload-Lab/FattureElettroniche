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
use \ArrayAccess;

class AltriDatiGestionali extends Tag implements ArrayAccess {
	
	use OffsetArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Tipo Dato
	 * Formato alfanumerico; lunghezza massima di 10 caratteri
	 * @var string
	 * @required yes
	 */
	protected $TipoDato;
	
	/**
	 * Riferimento Testo
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required yes
	 */
	protected $RiferimentoTesto;
	
	/**
	 * Riferimento Numero
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 21 caratteri
	 * @var string
	 * @required yes
	 */
	protected $RiferimentoNumero;
	
	/**
	 * Riferimento Data
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required yes
	 */
	protected $RiferimentoData;
	
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
				
				// Tipo Dato
				if($name == 'TipoDato'){
					
					if(!preg_match('/^[a-zA-Z0-9]+$/', $value) 
						|| strlen($value) > 10
					){
						
						$this->err()->setErrors(_('Tipo Dato "'.$value.'": Formato alfanumerico; lunghezza massima di 10 caratteri in '.$classname));
						return;
					}
				}
				
				// Riferimento Testo
				if($name == 'RiferimentoTesto'){
					
					if(!is_string($value) 
						|| strlen($value) > 60
					){
						
						$this->err()->setErrors(_('Riferimento Testo "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.$classname));
						return;
					}
				}
					
				// Riferimento Numero
				if($name == 'RiferimentoNumero'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 21
					){
						
						$this->err()->setErrors(_('Riferimento Numero "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 21 caratteri in '.$classname));
						return;
					}
				}
				
				// Riferimento Data
				if($name == 'RiferimentoData'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						
						$this->err()->setErrors(_('Riferimento Data "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.$classname));
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
		
				// Tipo Dato
				if($var->TipoDato != ''){
					
					$child = parent::$_dom->createElement('TipoDato', $var->TipoDato);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Tipo Dato: Il tipo è obbligatorio in '.$classname));
				}
				
				// Riferimento Testo
				if($var->RiferimentoTesto != ''){
					
					$child = parent::$_dom->createElement('RiferimentoTesto', $var->RiferimentoTesto);
					
					$elem->appendChild($child);
				}
				
				// Riferimento Numero
				if($var->RiferimentoNumero != ''){
					
					$child = parent::$_dom->createElement('RiferimentoNumero', $var->RiferimentoNumero);
					
					$elem->appendChild($child);
				}
				
				// Riferimento Data
				if($var->RiferimentoData != ''){
					
					$child = parent::$_dom->createElement('RiferimentoData', $var->RiferimentoData);
					
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
		
		// Tipo Dato
		if(isset($xmldata->TipoDato) 
			&& $xmldata->TipoDato instanceof SimpleXMLElement
			&& (string) $xmldata->TipoDato != ''
		){
			
			$this->__set('TipoDato', (string) $xmldata->TipoDato);
		} else{
			
			$this->err()->setErrors(_('Tipo Dato: Il tipo è obbligatorio in '.$classname));
		}
		
		// Riferimento Testo
		if(isset($xmldata->RiferimentoTesto) 
			&& $xmldata->RiferimentoTesto instanceof SimpleXMLElement
			&& (string) $xmldata->RiferimentoTesto != ''
		){
			
			$this->__set('RiferimentoTesto', (string) $xmldata->RiferimentoTesto);
		}
		
		// Riferimento Numero
		if(isset($xmldata->RiferimentoNumero) 
			&& $xmldata->RiferimentoNumero instanceof SimpleXMLElement
			&& (string) $xmldata->RiferimentoNumero != ''
		){
			
			$this->__set('RiferimentoNumero', (string) $xmldata->RiferimentoNumero);
		}
		
		// Riferimento Data
		if(isset($xmldata->RiferimentoData) 
			&& $xmldata->RiferimentoData instanceof SimpleXMLElement
			&& (string) $xmldata->RiferimentoData != ''
		){
			
			$this->__set('RiferimentoData', (string) $xmldata->RiferimentoData);
		}
		
		return $this;
	}
}