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

class DatiBollo extends Tag {
	
	/**
	 * Bollo Virtuale
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required yes
	 */
	protected $BolloVirtuale;
	
	/**
	 * Importo Bollo
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $ImportoBollo;
	
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
				
				// Bollo Virtuale
				if($name == 'BolloVirtuale'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$BV[$value])){
						
						$this->err()->setErrors(_('Bollo Virtuale "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Importo Bollo
				if($name == 'ImportoBollo'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						$this->err()->setErrors(_('Importo Bollo "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.__FILE__.' on line '.__LINE__));
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
		
		$elem = parent::$_dom->createElement($classname);
		
		// Bollo Virtuale
		if($this->BolloVirtuale != ''){
			
			$child = parent::$_dom->createElement('BolloVirtuale', $this->BolloVirtuale);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Bollo Virtuale: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Importo Bollo
		if($this->ImportoBollo != ''){
			
			$child = parent::$_dom->createElement('ImportoBollo', $this->ImportoBollo);
			
			$elem->appendChild($child);
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
		
		// Bollo Virtuale
		if(isset($xmldata->BolloVirtuale) 
			&& $xmldata->BolloVirtuale instanceof SimpleXMLElement
			&& (string) $xmldata->BolloVirtuale != ''
		){
			$this->__set('BolloVirtuale', (string) $xmldata->BolloVirtuale);
		} else{
			
			$this->err()->setErrors(_('Bollo Virtuale: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
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
		
		// Importo Bollo
		if(isset($xmldata->ImportoBollo) 
			&& $xmldata->ImportoBollo instanceof SimpleXMLElement
			&& (string) $xmldata->ImportoBollo != ''
		){
			$this->__set('ImportoBollo', (string) $xmldata->ImportoBollo);
		}
		
		return $this;
	}
}
