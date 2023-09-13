<?php
/***
 * F5 - Fatture elettroniche
 * 
 * Copyright © 2023
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
use \Iterator;
use \Countable;

class DatiRitenuta extends Tag implements ArrayAccess, Iterator, Countable {
	
	use OffsetArray;
	use IteratorArray;
	use CountArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Tipo Ritenuta
	 * Formato alfanumerico; lunghezza di 4 caratteri
	 * @var string
	 * @required yes
	 */
	protected $TipoRitenuta;
	
	/**
	 * Importo Ritenuta
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required yes
	 */
	protected $ImportoRitenuta;
	
	/**
	 * Aliquota Ritenuta
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 6 caratteri
	 * @var string
	 * @required yes
	 */
	protected $AliquotaRitenuta;
	
	/**
	 * Causale Pagamento
	 * Formato alfanumerico; lunghezza di massimo 2 caratteri
	 * @var string
	 * @required no
	 */
	protected $CausalePagamento;
	
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
				
				// Tipo Ritenuta
				if($name == 'TipoRitenuta'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$TR[$value])){
						
						$this->err()->setErrors(_('Tipo Ritenuta "'.$value.'": Formato alfanumerico; lunghezza di 4 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Importo Ritenuta
				if($name == 'ImportoRitenuta'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						$this->err()->setErrors(_('Importo Ritenuta "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Aliquota Ritenuta
				if($name == 'AliquotaRitenuta'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 6
					){
						$this->err()->setErrors(_('Aliquota Ritenuta "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 6 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Causale Pagamento
				if($name == 'CausalePagamento'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!is_string($value) 
						|| strlen($value) > 2
					){
						$this->err()->setErrors(_('Causale Pagamento "'.$value.'": Formato alfanumerico; lunghezza di massimo 2 caratteri in '.__FILE__.' on line '.__LINE__));
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
		
				// Tipo Ritenuta
				if($var->TipoRitenuta != ''){
					
					$child = parent::$_dom->createElement('TipoRitenuta', $var->TipoRitenuta);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Tipo Ritenuta: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
				}
				
				// Importo Ritenuta
				if($var->ImportoRitenuta != ''){
					
					$child = parent::$_dom->createElement('ImportoRitenuta', $var->ImportoRitenuta);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Importo Ritenuta: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
				}
				
				// Aliquota Ritenuta
				if($var->AliquotaRitenuta != ''){
					
					$child = parent::$_dom->createElement('AliquotaRitenuta', $var->AliquotaRitenuta);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Aliquota Ritenuta: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
				}
				
				// Causale Pagamento
				if($var->CausalePagamento != ''){
					
					$child = parent::$_dom->createElement('CausalePagamento', $var->CausalePagamento);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Causale Pagamento: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
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
		
		// Tipo Ritenuta
		if(isset($xmldata->TipoRitenuta) 
			&& $xmldata->TipoRitenuta instanceof SimpleXMLElement
			&& (string) $xmldata->TipoRitenuta != ''
		){
			$this->__set('TipoRitenuta', (string) $xmldata->TipoRitenuta);
		} else{
			
			$this->err()->setErrors(_('Tipo Ritenuta: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Importo Ritenuta
		if(isset($xmldata->ImportoRitenuta) 
			&& $xmldata->ImportoRitenuta instanceof SimpleXMLElement
			&& (string) $xmldata->ImportoRitenuta != ''
		){
			$this->__set('ImportoRitenuta', (string) $xmldata->ImportoRitenuta);
		} else{
			
			$this->err()->setErrors(_('Importo Ritenuta: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Aliquota Ritenuta
		if(isset($xmldata->AliquotaRitenuta) 
			&& $xmldata->AliquotaRitenuta instanceof SimpleXMLElement
			&& (string) $xmldata->AliquotaRitenuta != ''
		){
			$this->__set('AliquotaRitenuta', (string) $xmldata->AliquotaRitenuta);
		} else{
			
			$this->err()->setErrors(_('Aliquota Ritenuta: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Causale Pagamento
		if(isset($xmldata->CausalePagamento) 
			&& $xmldata->CausalePagamento instanceof SimpleXMLElement
			&& (string) $xmldata->CausalePagamento != ''
		){
			$this->__set('CausalePagamento', (string) $xmldata->CausalePagamento);
		} else{
			
			$this->err()->setErrors(_('Causale Pagamento: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		return $this;
	}
}
