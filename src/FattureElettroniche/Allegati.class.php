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

class Allegati extends Tag implements ArrayAccess {
	
	use OffsetArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Nome Attachment
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required no
	 */
	protected $NomeAttachment;
	
	/**
	 * Algoritmo Compressione
	 * Formato alfanumerico; lunghezza massima di 10 caratteri
	 * @var string
	 * @required yes
	 */
	protected $AlgoritmoCompressione;
	
	/**
	 * Formato Attachment
	 * Formato alfanumerico; lunghezza massima di 10 caratteri
	 * @var string
	 * @required no
	 */
	protected $FormatoAttachment;
	
	/**
	 * Descrizione Attachment
	 * Formato alfanumerico; lunghezza massima di 100 caratteri
	 * @var string
	 * @required no
	 */
	protected $DescrizioneAttachment;
	
	/**
	 * Attachment
	 * Formato xs:base64Binary
	 * @var string
	 * @required no
	 */
	protected $Attachment;
	
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
			  
				// Nome Attachment
				if($name == 'NomeAttachment'){
				
					if(!is_string($value) 
						|| strlen($value) > 60
					){
					
						$this->err()->setErrors(_('Nome Attachment "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.$classname));
						return;
					}
				}
				
				// Algoritmo Compressione
				if($name == 'AlgoritmoCompressione'){
					
					if(!is_string($value) 
						|| strlen($value) > 10
					){
						
						$this->err()->setErrors(_('Algoritmo Compressione "'.$value.'": Formato alfanumerico; lunghezza massima di 10 caratteri in '.$classname));
						return;
					}
				}
				
				// Formato Attachment
				if($name == 'FormatoAttachment'){
					
					if(!is_string($value) 
						|| strlen($value) > 10
					){
						
						$this->err()->setErrors(_('Formato Attachment "'.$value.'": Formato alfanumerico; lunghezza massima di 10 caratteri in '.$classname));
						return;
					}
				}
				
				// Descrizione Attachment
				if($name == 'DescrizioneAttachment'){
					
					if(!is_string($value) 
						|| strlen($value) > 100
					){
						
						$this->err()->setErrors(_('Descrizione Attachment "'.$value.'": Formato alfanumerico; lunghezza massima di 100 caratteri in '.$classname));
						return;
					}
				}
				
				// Attachment
				if($name == 'Attachment'){
					
					if(!is_string($value)){
						
						$this->err()->setErrors(_('Attachment "'.$value.'": Formato xs:base64Binary in '.$classname));
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
				
				// Nome Attachment
				if($var->NomeAttachment != ''){
					
					$child = parent::$_dom->createElement('NomeAttachment', $var->NomeAttachment);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Nome Attachment: Il tipo è obbligatorio in '.$classname));
				}
				
				// Algoritmo Compressione
				if($var->AlgoritmoCompressione != ''){
					
					$child = parent::$_dom->createElement('AlgoritmoCompressione', $var->AlgoritmoCompressione);
					
					$elem->appendChild($child);
				}
				
				// Formato Attachment
				if($var->FormatoAttachment != ''){
					
					$child = parent::$_dom->createElement('FormatoAttachment', $var->FormatoAttachment);
					
					$elem->appendChild($child);
				}
				
				// Descrizione Attachment
				if($var->DescrizioneAttachment != ''){
					
					$child = parent::$_dom->createElement('DescrizioneAttachment', $var->DescrizioneAttachment);
					
					$elem->appendChild($child);
				}
				
				// Attachment
				if($var->Attachment != ''){
					
					$child = parent::$_dom->createElement('Attachment', $var->Attachment);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Attachment: Il tipo è obbligatorio in '.$classname));
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
		
		// Nome Attachment
		if(isset($xmldata->NomeAttachment) 
			&& $xmldata->NomeAttachment instanceof SimpleXMLElement
			&& (string) $xmldata->NomeAttachment != ''
		){
			
			$this->__set('NomeAttachment', (string) $xmldata->NomeAttachment);
		} else{
			
			$this->err()->setErrors(_('Nome Attachment: Il tipo è obbligatorio in '.$classname));
		}
		
		// Algoritmo Compressione
		if(isset($xmldata->AlgoritmoCompressione) 
			&& $xmldata->AlgoritmoCompressione instanceof SimpleXMLElement
			&& (string) $xmldata->AlgoritmoCompressione != ''
		){
			
			$this->__set('AlgoritmoCompressione', (string) $xmldata->AlgoritmoCompressione);
		}
		
		// Formato Attachment
		if(isset($xmldata->FormatoAttachment) 
			&& $xmldata->FormatoAttachment instanceof SimpleXMLElement
			&& (string) $xmldata->FormatoAttachment != ''
		){
			
			$this->__set('FormatoAttachment', (string) $xmldata->FormatoAttachment);
		}
		
		// Descrizione Attachment
		if(isset($xmldata->DescrizioneAttachment) 
			&& $xmldata->DescrizioneAttachment instanceof SimpleXMLElement
			&& (string) $xmldata->DescrizioneAttachment != ''
		){
			
			$this->__set('DescrizioneAttachment', (string) $xmldata->DescrizioneAttachment);
		}
		
		// Attachment
		if(isset($xmldata->Attachment) 
			&& $xmldata->Attachment instanceof SimpleXMLElement
			&& (string) $xmldata->Attachment != ''
		){
			
			$this->__set('Attachment', (string) $xmldata->Attachment);
		} else{
			
			$this->err()->setErrors(_('Attachment: Il tipo è obbligatorio in '.$classname));
		}
		
		return $this;
	}
}