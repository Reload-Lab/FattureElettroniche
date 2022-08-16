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

class DatiRiepilogo extends Tag implements ArrayAccess {
	
	use OffsetArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Aliquota IVA
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 6 caratteri
	 * @var string
	 * @required yes
	 */
	protected $AliquotaIVA;
	
	/**
	 * Natura
	 * Formato alfanumerico; lunghezza da 2 a 4 caratteri
	 * @var string
	 * @required no
	 */
	protected $Natura;
	
	/**
	 * Spese Accessorie
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $SpeseAccessorie;
	
	/**
	 * Arrotondamento
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $Arrotondamento;
	
	/**
	 * Imponibile Importo
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required yes
	 */
	protected $ImponibileImporto;
	
	/**
	 * Imposta
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Imposta;
	
	/**
	 * Esigibilita IVA
	 * Formato alfanumerico; lunghezza di 1 carattere
	 * @var string
	 * @required no
	 */
	protected $EsigibilitaIVA;
	
	/**
	 * Riferimento Normativo
	 * Formato alfanumerico; lunghezza massima di 100 caratteri
	 * @var string
	 * @required no
	 */
	protected $RiferimentoNormativo;
	
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
				
				// Natura
				if($name == 'Natura'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$NT[$value])){
						
						$this->err()->setErrors(_('Natura "'.$value.'": Formato alfanumerico; lunghezza da 2 a 4 caratteri in '.$classname));
						return;
					}
				}
				
				// Spese Accessorie
				if($name == 'SpeseAccessorie'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						
						$this->err()->setErrors(_('Spese Accessorie "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.$classname));
						return;
					}
				}
				
				// Arrotondamento
				if($name == 'Arrotondamento'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						
						$this->err()->setErrors(_('Arrotondamento "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.$classname));
						return;
					}
				}
				
				// Imponibile Importo
				if($name == 'ImponibileImporto'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						
						$this->err()->setErrors(_('Imponibile Importo "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.$classname));
						return;
					}
				}
				
				// Imposta
				if($name == 'Imposta'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						
						$this->err()->setErrors(_('Imposta "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.$classname));
						return;
					}
				}
				
				// Esigibilita IVA
				if($name == 'EsigibilitaIVA'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$EI[$value])){
						
						$this->err()->setErrors(_('Esigibilita IVA "'.$value.'": Formato alfanumerico; lunghezza di 1 carattere in '.$classname));
						return;
					}
				}
				
				// Riferimento Normativo
				if($name == 'RiferimentoNormativo'){
					
					if(!is_string($value) 
						|| strlen($value) > 100
					){
						
						$this->err()->setErrors(_('Riferimento Normativo "'.$value.'": Formato alfanumerico; lunghezza massima di 100 caratteri in '.$classname));
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

				// Aliquota IVA
				if($var->AliquotaIVA != ''){
					
					$child = parent::$_dom->createElement('AliquotaIVA', $var->AliquotaIVA);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Aliquota IVA: Il tipo è obbligatorio in '.$classname));
				}
				
				// Natura
				if($var->Natura != ''){
					
					$child = parent::$_dom->createElement('Natura', $var->Natura);
					
					$elem->appendChild($child);
				}
				
				// Spese Accessorie
				if($var->SpeseAccessorie != ''){
					
					$child = parent::$_dom->createElement('SpeseAccessorie', $var->SpeseAccessorie);
					
					$elem->appendChild($child);
				}
				
				// Arrotondamento
				if($var->Arrotondamento != ''){
					
					$child = parent::$_dom->createElement('Arrotondamento', $var->Arrotondamento);
					
					$elem->appendChild($child);
				}
				
				// Imponibile Importo
				if($var->ImponibileImporto != ''){
					
					$child = parent::$_dom->createElement('ImponibileImporto', $var->ImponibileImporto);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Imponibile Importo: Il tipo è obbligatorio in '.$classname));
				}
				
				// Imposta
				if($var->Imposta != ''){
					
					$child = parent::$_dom->createElement('Imposta', $var->Imposta);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Imposta: Il tipo è obbligatorio in '.$classname));
				}
				
				// Esigibilita IVA
				if($var->EsigibilitaIVA != ''){
					
					$child = parent::$_dom->createElement('EsigibilitaIVA', $var->EsigibilitaIVA);
					
					$elem->appendChild($child);
				}
				
				// Riferimento Normativo
				if($var->RiferimentoNormativo != ''){
					
					$child = parent::$_dom->createElement('RiferimentoNormativo', $var->RiferimentoNormativo);
					
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
		
		// Aliquota IVA
		if(isset($xmldata->AliquotaIVA) 
			&& $xmldata->AliquotaIVA instanceof SimpleXMLElement
			&& (string) $xmldata->AliquotaIVA != ''
		){
			
			$this->__set('AliquotaIVA', (string) $xmldata->AliquotaIVA);
		} else{
			
			$this->err()->setErrors(_('Aliquota IVA: Il tipo è obbligatorio in '.$classname));
		}
		
		// Natura
		if(isset($xmldata->Natura) 
			&& $xmldata->Natura instanceof SimpleXMLElement
			&& (string) $xmldata->Natura != ''
		){
			
			$this->__set('Natura', (string) $xmldata->Natura);
		}
		
		// Spese Accessorie
		if(isset($xmldata->SpeseAccessorie) 
			&& $xmldata->SpeseAccessorie instanceof SimpleXMLElement
			&& (string) $xmldata->SpeseAccessorie != ''
		){
			
			$this->__set('SpeseAccessorie', (string) $xmldata->SpeseAccessorie);
		}
		
		// Arrotondamento
		if(isset($xmldata->Arrotondamento) 
			&& $xmldata->Arrotondamento instanceof SimpleXMLElement
			&& (string) $xmldata->Arrotondamento != ''
		){
			
			$this->__set('Arrotondamento', (string) $xmldata->Arrotondamento);
		}
		
		// Imponibile Importo
		if(isset($xmldata->ImponibileImporto) 
			&& $xmldata->ImponibileImporto instanceof SimpleXMLElement
			&& (string) $xmldata->ImponibileImporto != ''
		){
			
			$this->__set('ImponibileImporto', (string) $xmldata->ImponibileImporto);
		} else{
			
			$this->err()->setErrors(_('Imponibile Importo: Il tipo è obbligatorio in '.$classname));
		}
		
		// Imposta
		if(isset($xmldata->Imposta) 
			&& $xmldata->Imposta instanceof SimpleXMLElement
			&& (string) $xmldata->Imposta != ''
		){
			
			$this->__set('Imposta', (string) $xmldata->Imposta);
		} else{
			
			$this->err()->setErrors(_('Imposta: Il tipo è obbligatorio in '.$classname));
		}
		
		// Esigibilita IVA
		if(isset($xmldata->EsigibilitaIVA) 
			&& $xmldata->EsigibilitaIVA instanceof SimpleXMLElement
			&& (string) $xmldata->EsigibilitaIVA != ''
		){
			
			$this->__set('EsigibilitaIVA', (string) $xmldata->EsigibilitaIVA);
		}
		
		// Riferimento Normativo
		if(isset($xmldata->RiferimentoNormativo) 
			&& $xmldata->RiferimentoNormativo instanceof SimpleXMLElement
			&& (string) $xmldata->RiferimentoNormativo != ''
		){
			
			$this->__set('RiferimentoNormativo', (string) $xmldata->RiferimentoNormativo);
		}
		
		return $this;
	}
}