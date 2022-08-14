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
use \ArrayAccess;

class DatiCassaPrevidenziale extends Tag implements ArrayAccess {
	
	use OffsetArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Tipo Cassa
	 * Formato alfanumerico; lunghezza di 4 caratteri
	 * @var string
	 * @required yes
	 */
	protected $TipoCassa;
	
	/**
	 * Aliquota Cassa
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 6 caratteri
	 * @var string
	 * @required yes
	 */
	protected $AlCassa;
	
	/**
	 * Importo Contributo Cassa
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required yes
	 */
	protected $ImportoContributoCassa;
	
	/**
	 * Imponibile Cassa
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $ImponibileCassa;
	
	/**
	 * Aliquota IVA
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 6 caratteri
	 * @var string
	 * @required yes
	 */
	protected $AliquotaIVA;
	
	/**
	 * Ritenuta
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required no
	 */
	protected $Ritenuta;
	
	/**
	 * Natura
	 * Formato alfanumerico; lunghezza da 2 a 4 caratteri
	 * @var string
	 * @required no
	 */
	protected $Natura;
	
	/**
	 * Riferimento Amministrazione
	 * Formato alfanumerico; lunghezza massima di 20 caratteri
	 * @var string
	 * @required no
	 */
	protected $RiferimentoAmministrazione;
	
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
				
				// Tipo Cassa
				if($name == 'TipoCassa'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$TC[$value])){
						
						$this->err()->setErrors(_('Tipo Cassa "'.$value.'": Formato alfanumerico; lunghezza di 4 caratteri in '.$classname));
						return;
					}
				}
				
				// Aliquota Cassa
				if($name == 'AlCassa'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 6
					){
						
						$this->err()->setErrors(_('Aliquota Cassa "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 6 caratteri in '.$classname));
						return;
					}
				}
				
				// Importo Contributo Cassa
				if($name == 'ImportoContributoCassa'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						
						$this->err()->setErrors(_('Importo Contributo Cassa "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.$classname));
						return;
					}
				}
				
				// Imponibile Cassa
				if($name == 'ImponibileCassa'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						
						$this->err()->setErrors(_('Imponibile Cassa "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.$classname));
						return;
					}
				}
				
				// Aliquota IVA
				if($name == 'AliquotaIVA'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 6
					){
						
						$this->err()->setErrors(_('Aliquota IVA "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 6 caratteri in '.$classname));
						return;
					}
				}
				
				// Ritenuta
				if($name == 'Ritenuta'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$RTC[$value])){
						
						$this->err()->setErrors(_('Ritenuta "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.$classname));
						return;
					}
				}
				
				// Natura
				if($name == 'Natura'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$NT[$value])){
						
						$this->err()->setErrors(_('Natura "'.$value.'": Formato alfanumerico; lunghezza da 2 a 4 caratteri in '.$classname));
						return;
					}
				}
				
				// Riferimento Amministrazione
				if($name == 'RiferimentoAmministrazione'){
					
					if(!is_string($value) 
						|| strlen($value) > 20
					){
						
						$this->err()->setErrors(_('Riferimento Amministrazione "'.$value.'": Formato alfanumerico; lunghezza massima di 20 caratteri in '.$classname));
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
				
				// Tipo Cassa
				if($var->TipoCassa != ''){
					
					$child = parent::$_dom->createElement('TipoCassa', $var->TipoCassa);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Tipo Cassa: Il tipo è obbligatorio in '.$classname));
				}
				
				// Aliquota Cassa
				if($var->AlCassa != ''){
					
					$child = parent::$_dom->createElement('AlCassa', $var->AlCassa);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Aliquota Cassa: Il tipo è obbligatorio in '.$classname));
				}
				
				// Importo Contributo Cassa
				if($var->ImportoContributoCassa != ''){
					
					$child = parent::$_dom->createElement('ImportoContributoCassa', $var->ImportoContributoCassa);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Importo Contributo Cassa: Il tipo è obbligatorio in '.$classname));
				}
				
				// Imponibile Cassa
				if($var->ImponibileCassa != ''){
					
					$child = parent::$_dom->createElement('ImponibileCassa', $var->ImponibileCassa);
					
					$elem->appendChild($child);
				}
				
				// Aliquota IVA
				if($var->AliquotaIVA != ''){
					
					$child = parent::$_dom->createElement('AliquotaIVA', $var->AliquotaIVA);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Aliquota IVA: Il tipo è obbligatorio in '.$classname));
				}
				
				// Ritenuta
				if($var->Ritenuta != ''){
					
					$child = parent::$_dom->createElement('Ritenuta', $var->Ritenuta);
					
					$elem->appendChild($child);
				}
				
				// Natura
				if($var->Natura != ''){
					
					$child = parent::$_dom->createElement('Natura', $var->Natura);
					
					$elem->appendChild($child);
				}
				
				// Riferimento Amministrazione
				if($var->RiferimentoAmministrazione != ''){
					
					$child = parent::$_dom->createElement('RiferimentoAmministrazione', $var->RiferimentoAmministrazione);
					
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
		
		// Tipo Cassa
		if(isset($xmldata->TipoCassa) 
			&& $xmldata->TipoCassa instanceof SimpleXMLElement
			&& (string) $xmldata->TipoCassa != ''
		){
			
			$this->__set('TipoCassa', (string) $xmldata->TipoCassa);
		} else{
			
			$this->err()->setErrors(_('Tipo Cassa: Il tipo è obbligatorio in '.$classname));
		}
		
		// Aliquota Cassa
		if(isset($xmldata->AlCassa) 
			&& $xmldata->AlCassa instanceof SimpleXMLElement
			&& (string) $xmldata->AlCassa != ''
		){
			
			$this->__set('AlCassa', (string) $xmldata->AlCassa);
		} else{
			
			$this->err()->setErrors(_('Aliquota Cassa: Il tipo è obbligatorio in '.$classname));
		}
		
		// Importo Contributo Cassa
		if(isset($xmldata->ImportoContributoCassa) 
			&& $xmldata->ImportoContributoCassa instanceof SimpleXMLElement
			&& (string) $xmldata->ImportoContributoCassa != ''
		){
			
			$this->__set('ImportoContributoCassa', (string) $xmldata->ImportoContributoCassa);
		} else{
			
			$this->err()->setErrors(_('Importo Contributo Cassa: Il tipo è obbligatorio in '.$classname));
		}
		
		// Imponibile Cassa
		if(isset($xmldata->ImponibileCassa) 
			&& $xmldata->ImponibileCassa instanceof SimpleXMLElement
			&& (string) $xmldata->ImponibileCassa != ''
		){
			
			$this->__set('ImponibileCassa', (string) $xmldata->ImponibileCassa);
		}
		
		// Aliquota IVA
		if(isset($xmldata->AliquotaIVA) 
			&& $xmldata->AliquotaIVA instanceof SimpleXMLElement
			&& (string) $xmldata->AliquotaIVA != ''
		){
			
			$this->__set('AliquotaIVA', (string) $xmldata->AliquotaIVA);
		} else{
			
			$this->err()->setErrors(_('Aliquota IVA: Il tipo è obbligatorio in '.$classname));
		}
		
		// Ritenuta
		if(isset($xmldata->Ritenuta) 
			&& $xmldata->Ritenuta instanceof SimpleXMLElement
			&& (string) $xmldata->Ritenuta != ''
		){
			
			$this->__set('Ritenuta', (string) $xmldata->Ritenuta);
		}
		
		// Natura
		if(isset($xmldata->Natura) 
			&& $xmldata->Natura instanceof SimpleXMLElement
			&& (string) $xmldata->Natura != ''
		){
			
			$this->__set('Natura', (string) $xmldata->Natura);
		}
		
		// Riferimento Amministrazione
		if(isset($xmldata->RiferimentoAmministrazione) 
			&& $xmldata->RiferimentoAmministrazione instanceof SimpleXMLElement
			&& (string) $xmldata->RiferimentoAmministrazione != ''
		){
			
			$this->__set('RiferimentoAmministrazione', (string) $xmldata->RiferimentoAmministrazione);
		}
		
		return $this;
	}
}