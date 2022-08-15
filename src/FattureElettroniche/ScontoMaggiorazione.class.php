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

class ScontoMaggiorazione extends Tag implements ArrayAccess {
	
	use OffsetArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Tipo
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Tipo;
	
	/**
	 * Percentuale
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 6 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Percentuale;
	
	/**
	 * Importo
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 21 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Importo;
	
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
				
				// Tipo
				if($name == 'Tipo'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$TSM[$value])){
						
						$this->err()->setErrors(_('Tipo "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.$classname));
						return;
					}
				}
				
				// Percentuale
				if($name == 'Percentuale'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 6
					){
						
						$this->err()->setErrors(_('Percentuale "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 6 caratteri in '.$classname));
						return;
					}
				}
				
				// Importo
				if($name == 'Importo'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 21
					){
						
						$this->err()->setErrors(_('Importo "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 21 caratteri in '.$classname));
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
		
				// Tipo
				if($var->Tipo != ''){
					
					$child = parent::$_dom->createElement('Tipo', $var->Tipo);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Tipo: Il tipo è obbligatorio in '.$classname));
				}
				
				// Percentuale
				if($var->Percentuale != ''){
					
					$child = parent::$_dom->createElement('Percentuale', $var->Percentuale);
					
					$elem->appendChild($child);
				}
				
				// Importo
				if($var->Importo != ''){
					
					$child = parent::$_dom->createElement('Importo', $var->Importo);
					
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
		
		// Tipo
		if(isset($xmldata->Tipo) 
			&& $xmldata->Tipo instanceof SimpleXMLElement
			&& (string) $xmldata->Tipo != ''
		){
			
			$this->__set('Tipo', (string) $xmldata->Tipo);
		} else{
			
			$this->err()->setErrors(_('Tipo: Il tipo è obbligatorio in '.$classname));
		}
		
		// Percentuale
		if(isset($xmldata->Percentuale) 
			&& $xmldata->Percentuale instanceof SimpleXMLElement
			&& (string) $xmldata->Percentuale != ''
		){
			
			$this->__set('Percentuale', (string) $xmldata->Percentuale);
		}
		
		// Importo
		if(isset($xmldata->Importo) 
			&& $xmldata->Importo instanceof SimpleXMLElement
			&& (string) $xmldata->Importo != ''
		){
			
			$this->__set('Importo', (string) $xmldata->Importo);
		}
		
		return $this;
	}
}