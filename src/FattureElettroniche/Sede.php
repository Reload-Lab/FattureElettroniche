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

class Sede extends Tag {
	
	/**
	 * Indirizzo
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Indirizzo;
	
	/**
	 * Numero Civico
	 * Formato alfanumerico; lunghezza massima di 8 caratteri
	 * @var string
	 * @required no
	 */
	protected $NumeroCivico;
	
	/**
	 * CAP
	 * Formato numerico; lunghezza di 5 caratteri
	 * @var string
	 * @required yes
	 */
	protected $CAP;
	
	/**
	 * Comune
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Comune;
	
	/**
	 * Provincia
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required no
	 */
	protected $Provincia;
	
	/**
	 * Nazione
	 * Sigla della nazione espressa secondo lo standard ISO 3166-1 alpha-2 code
	 * @var string
	 * @required yes
	 */
	protected $Nazione;
	
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
				
				// Indirizzo
				if($name == 'Indirizzo'){
					
					if(!is_string($value) 
						|| strlen($value) > 60
					){
						
						$this->err()->setErrors(_('Indirizzo "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.$classname));
						return;
					}
				}
				
				// Numero Civico
				if($name == 'NumeroCivico'){
					
					if((!is_string($value) 
						&& !is_numeric($value))
						|| strlen($value) > 8
					){
						
						$this->err()->setErrors(_('Numero Civico "'.$value.'": Formato alfanumerico; lunghezza massima di 8 caratteri in '.$classname));
						return;
					}
				}
				
				// CAP
				if($name == 'CAP'){
					
					if(!preg_match('/^[0-9]+$/', $value) 
						|| strlen($value) != 5
					){
						
						$this->err()->setErrors(_('CAP "'.$value.'": Formato numerico; lunghezza di 5 caratteri in '.$classname));
						return;
					}
				}
				
				// Comune
				if($name == 'Comune'){
					
					if(!is_string($value) 
						|| strlen($value) > 60
					){
						
						$this->err()->setErrors(_('Comune "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.$classname));
						return;
					}
				}
				
				// Provincia
				if($name == 'Provincia'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$PI[$value])){
						
						$this->err()->setErrors(_('Provincia "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.$classname));
						return;
					}
				}
				
				// Nazione
				if($name == 'Nazione'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!preg_match('/^[A-Z]+$/', $value) 
						|| strlen($value) != 2
					){
						
						$this->err()->setErrors(_('Nazione "'.$value.'": Sigla della nazione espressa secondo lo standard ISO 3166-1 alpha-2 code in '.$classname));
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
		
		// Indirizzo
		if($this->Indirizzo != ''){
			
			$child = parent::$_dom->createElement('Indirizzo', $this->Indirizzo);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Indirizzo: Il tipo è obbligatorio in '.$classname));
		}
		
		// Numero Civico
		if($this->NumeroCivico != ''){
			
			$child = parent::$_dom->createElement('NumeroCivico', $this->NumeroCivico);
			
			$elem->appendChild($child);
		}
		
		// CAP
		if($this->CAP != ''){
			
			$child = parent::$_dom->createElement('CAP', $this->CAP);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('CAP: Il tipo è obbligatorio in '.$classname));
		}
		
		// Comune
		if($this->Comune != ''){
			
			$child = parent::$_dom->createElement('Comune', $this->Comune);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Comune: Il tipo è obbligatorio in '.$classname));
		}
		
		// Provincia
		if($this->Provincia != ''){
			
			$child = parent::$_dom->createElement('Provincia', $this->Provincia);
			
			$elem->appendChild($child);
		}
		
		// Nazione
		if($this->Nazione != ''){
			
			$child = parent::$_dom->createElement('Nazione', $this->Nazione);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Nazione: Il tipo è obbligatorio in '.$classname));
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
		
		// Indirizzo
		if(isset($xmldata->Indirizzo) 
			&& $xmldata->Indirizzo instanceof SimpleXMLElement
			&& (string) $xmldata->Indirizzo != ''
		){
			
			$this->__set('Indirizzo', (string) $xmldata->Indirizzo);
		} else{
			
			$this->err()->setErrors(_('Indirizzo: Il tipo è obbligatorio in '.$classname));
		}
		
		// Numero Civico
		if(isset($xmldata->NumeroCivico) 
			&& $xmldata->NumeroCivico instanceof SimpleXMLElement
			&& (string) $xmldata->NumeroCivico != ''
		){
			
			$this->__set('NumeroCivico', (string) $xmldata->NumeroCivico);
		}
		
		// CAP
		if(isset($xmldata->CAP) 
			&& $xmldata->CAP instanceof SimpleXMLElement
			&& (string) $xmldata->CAP != ''
		){
			
			$this->__set('CAP', (string) $xmldata->CAP);
		} else{
			
			$this->err()->setErrors(_('CAP: Il tipo è obbligatorio in '.$classname));
		}
		
		// Comune
		if(isset($xmldata->Comune) 
			&& $xmldata->Comune instanceof SimpleXMLElement
			&& (string) $xmldata->Comune != ''
		){
			
			$this->__set('Comune', (string) $xmldata->Comune);
		} else{
			
			$this->err()->setErrors(_('Comune: Il tipo è obbligatorio in '.$classname));
		}
		
		// Provincia
		if(isset($xmldata->Provincia) 
			&& $xmldata->Provincia instanceof SimpleXMLElement
			&& (string) $xmldata->Provincia != ''
		){
			
			$this->__set('Provincia', (string) $xmldata->Provincia);
		}
		
		// Nazione
		if(isset($xmldata->Nazione) 
			&& $xmldata->Nazione instanceof SimpleXMLElement
			&& (string) $xmldata->Nazione != ''
		){
			
			$this->__set('Nazione', (string) $xmldata->Nazione);
		} else{
			
			$this->err()->setErrors(_('Nazione: Il tipo è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}