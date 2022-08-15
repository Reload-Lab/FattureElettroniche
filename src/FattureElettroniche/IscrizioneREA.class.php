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

class IscrizioneREA extends Tag {
	
	/**
	 * Ufficio
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Ufficio;
	
	/**
	 * Numero REA
	 * Formato alfanumerico; lunghezza massima di 20 caratteri
	 * @var string
	 * @required yes
	 */
	protected $NumeroREA;
	
	/**
	 * Capitale Sociale
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $CapitaleSociale;
	
	/**
	 * Socio Unico
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required no
	 */
	protected $SocioUnico;
	
	/**
	 * Stato Liquidazione
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required yes
	 */
	protected $StatoLiquidazione;
	
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
				
				// Ufficio
				if($name == 'Ufficio'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!preg_match('/^[A-Z0-9]+$/', $value) 
						|| strlen($value) != 2
					){
						
						$this->err()->setErrors(_('Ufficio "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.$classname));
						return;
					}
				}
				
				// Numero REA
				if($name == 'NumeroREA'){
					
					if(!preg_match('/^[a-zA-Z0-9-]+$/', $value) 
						|| strlen($value) > 20
					){
						
						$this->err()->setErrors(_('Numero REA "'.$value.'": Formato alfanumerico; lunghezza massima di 20 caratteri in '.$classname));
						return;
					}
				}
				
				// Capitale Sociale
				if($name == 'CapitaleSociale'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						
						$this->err()->setErrors(_('Capitale Sociale "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.$classname));
						return;
					}
				}
				
				// Socio Unico
				if($name == 'SocioUnico'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$SU[$value])){
						
						$this->err()->setErrors(_('Socio Unico "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.$classname));
						return;
					}
				}
				
				// Stato Liquidazione
				if($name == 'StatoLiquidazione'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$SL[$value])){
						
						$this->err()->setErrors(_('Stato Liquidazione "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.$classname));
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
				
		// Ufficio
		if($this->Ufficio != ''){
			
			$child = parent::$_dom->createElement('Ufficio', $this->Ufficio);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Ufficio: Il tipo è obbligatorio in '.$classname));
		}
		
		// Numero REA
		if($this->NumeroREA != ''){
			
			$child = parent::$_dom->createElement('NumeroREA', $this->NumeroREA);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Numero REA: Il tipo è obbligatorio in '.$classname));
		}
		
		// Capitale Sociale
		if($this->CapitaleSociale != ''){
			
			$child = parent::$_dom->createElement('CapitaleSociale', $this->CapitaleSociale);
			
			$elem->appendChild($child);
		}
		
		// Socio Unico
		if($this->SocioUnico != ''){
			
			$child = parent::$_dom->createElement('SocioUnico', $this->SocioUnico);
			
			$elem->appendChild($child);
		}
		
		// Stato Liquidazione
		if($this->StatoLiquidazione != ''){
			
			$child = parent::$_dom->createElement('StatoLiquidazione', $this->StatoLiquidazione);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Stato Liquidazione: Il tipo è obbligatorio in '.$classname));
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
		
		// Ufficio
		if(isset($xmldata->Ufficio) 
			&& $xmldata->Ufficio instanceof SimpleXMLElement
			&& (string) $xmldata->Ufficio != ''
		){
			
			$this->__set('Ufficio', (string) $xmldata->Ufficio);
		} else{
			
			$this->err()->setErrors(_('Ufficio: Il tipo è obbligatorio in '.$classname));
		}
		
		// Numero REA
		if(isset($xmldata->NumeroREA) 
			&& $xmldata->NumeroREA instanceof SimpleXMLElement
			&& (string) $xmldata->NumeroREA != ''
		){
			
			$this->__set('NumeroREA', (string) $xmldata->NumeroREA);
		} else{
			
			$this->err()->setErrors(_('Numero REA: Il tipo è obbligatorio in '.$classname));
		}
		
		// Capitale Sociale
		if(isset($xmldata->CapitaleSociale) 
			&& $xmldata->CapitaleSociale instanceof SimpleXMLElement
			&& (string) $xmldata->CapitaleSociale != ''
		){
			
			$this->__set('CapitaleSociale', (string) $xmldata->CapitaleSociale);
		}
		
		// Socio Unico
		if(isset($xmldata->SocioUnico) 
			&& $xmldata->SocioUnico instanceof SimpleXMLElement
			&& (string) $xmldata->SocioUnico != ''
		){
			
			$this->__set('SocioUnico', (string) $xmldata->SocioUnico);
		}
		
		// Stato Liquidazione
		if(isset($xmldata->StatoLiquidazione) 
			&& $xmldata->StatoLiquidazione instanceof SimpleXMLElement
			&& (string) $xmldata->StatoLiquidazione != ''
		){
			
			$this->__set('StatoLiquidazione', (string) $xmldata->StatoLiquidazione);
		} else{
			
			$this->err()->setErrors(_('Stato Liquidazione: Il tipo è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}