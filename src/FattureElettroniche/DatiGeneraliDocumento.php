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
use \DOMNode;

class DatiGeneraliDocumento extends Tag {
	
	/**
	 * Tipo Documento
	 * Formato alfanumerico; lunghezza di 4 caratteri; i valori ammessi sono i seguenti
	 * @var string
	 * @required yes
	 */
	protected $TipoDocumento;
	
	/**
	 * Divisa
	 * Questo campo deve essere espresso secondo lo standard ISO 4217 alpha-3:2001 (es.: EUR, USD, GBP, CZK………)
	 * @var string
	 * @required yes
	 */
	protected $Divisa;
	
	/**
	 * Data
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required yes
	 */
	protected $Data;
	
	/**
	 * Numero
	 * Formato alfanumerico; lunghezza massima di 20 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Numero;
	
	/**
	 * Dati Ritenuta
	 * @var object type DatiRitenuta
	 * @required no
	 */
	protected $__DatiRitenuta;
	
	/**
	 * Dati Bollo
	 * @var object type DatiBollo
	 * @required no
	 */
	protected $__DatiBollo;
	
	/**
	 * Dati Cassa Previdenziale
	 * @var object type DatiCassaPrevidenziale
	 * @required no
	 */
	protected $__DatiCassaPrevidenziale;
	
	/**
	 * Sconto Maggiorazione
	 * @var object type ScontoMaggiorazione
	 * @required no
	 */
	protected $__ScontoMaggiorazione;
	
	/**
	 * ImportoTotaleDocumento
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $ImportoTotaleDocumento;
	
	/**
	 * Arrotondamento
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $Arrotondamento;
	
	/**
	 * Causale
	 * @var object type Causale
	 * @required no
	 */
	protected $__Causale;
	
	/**
	 * Art73
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required no
	 */
	protected $Art73;
	
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
				
				// Tipo Documento
				if($name == 'TipoDocumento'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$TD[$value])){
						
						$this->err()->setErrors(_('Tipo Documento "'.$value.'": Formato alfanumerico; lunghezza di 4 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Divisa
				if($name == 'Divisa'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!preg_match('/^[A-Z]+$/', $value) 
						|| strlen($value) > 3
					){
						$this->err()->setErrors(_('Divisa "'.$value.'": Questo campo deve essere espresso secondo lo standard ISO 4217 alpha-3:2001 (es.: EUR, USD, GBP, CZK………) in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Data
				if($name == 'Data'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						$this->err()->setErrors(_('Data "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Numero
				if($name == 'Numero'){
					
					if(!is_string($value) 
						|| strlen($value) > 20
					){
						$this->err()->setErrors(_('Numero "'.$value.'": Formato alfanumerico; lunghezza massima di 20 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Importo Totale Documento
				if($name == 'ImportoTotaleDocumento'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						$this->err()->setErrors(_('Importo Totale Documento "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Arrotondamento
				if($name == 'Arrotondamento'){
					
					if(!preg_match('/^[-+]?(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						$this->err()->setErrors(_('Arrotondamento "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Art73
				if($name == 'Art73'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$ART73[$value])){
						
						$this->err()->setErrors(_('Art73 "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.__FILE__.' on line '.__LINE__));
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
	 * @return array
	 */
	public function getXml()
	{
		$reflect = new ReflectionClass($this);
		$classname = $reflect->getShortName();
		
		$elem = parent::$_dom->createElement($classname);
		
		// Tipo Documento
		if($this->TipoDocumento != ''){
			
			$child = parent::$_dom->createElement('TipoDocumento', $this->TipoDocumento);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Tipo Documento: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Divisa
		if($this->Divisa != ''){
			
			$child = parent::$_dom->createElement('Divisa', $this->Divisa);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Divisa: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Data
		if($this->Data != ''){
			
			$child = parent::$_dom->createElement('Data', $this->Data);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Data: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Numero
		if($this->Numero != ''){
			
			$child = parent::$_dom->createElement('Numero', $this->Numero);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Numero: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Dati Ritenuta
		if($this->__DatiRitenuta instanceof DatiRitenuta){
			
			$childs = $this->__DatiRitenuta->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
						
						$elem->appendChild($var);
					}
				}
			}
		}
		
		// Dati Bollo
		if($this->__DatiBollo instanceof DatiBollo){
			
			$child = $this->__DatiBollo->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		}
		
		// Dati Cassa Previdenziale
		if($this->__DatiCassaPrevidenziale instanceof DatiCassaPrevidenziale){
			
			$childs = $this->__DatiCassaPrevidenziale->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
	
						$elem->appendChild($var);
					}
				}
			}
		}
		
		// Sconto Maggiorazione
		if($this->__ScontoMaggiorazione instanceof ScontoMaggiorazione){
			
			$childs = $this->__ScontoMaggiorazione->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
	
						$elem->appendChild($var);
					}
				}
			}
		}
		
		// Importo Totale Documento
		if($this->ImportoTotaleDocumento != ''){
			
			$child = parent::$_dom->createElement('ImportoTotaleDocumento', $this->ImportoTotaleDocumento);
			
			$elem->appendChild($child);
		}
		
		// Arrotondamento
		if($this->Arrotondamento != ''){
			
			$child = parent::$_dom->createElement('Arrotondamento', $this->Arrotondamento);
			
			$elem->appendChild($child);
		}
		
		// Causale
		if($this->__Causale instanceof Causale){
			
			$childs = $this->__Causale->getXml();
			
			if(count($childs)){
				
				foreach($childs as $var){
					
					if($var instanceof DOMNode){
						
						$elem->appendChild($var);
					}
				}
			}
		}
		
		// Art73
		if($this->Art73 != ''){
			
			$child = parent::$_dom->createElement('Art73', $this->Art73);
			
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
		
		// Tipo Documento
		if(isset($xmldata->TipoDocumento) 
			&& $xmldata->TipoDocumento instanceof SimpleXMLElement
			&& (string) $xmldata->TipoDocumento != ''
		){
			$this->__set('TipoDocumento', (string) $xmldata->TipoDocumento);
		} else{
			
			$this->err()->setErrors(_('Tipo Documento: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Divisa
		if(isset($xmldata->Divisa) 
			&& $xmldata->Divisa instanceof SimpleXMLElement
			&& (string) $xmldata->Divisa != ''
		){
			$this->__set('Divisa', (string) $xmldata->Divisa);
		} else{
			
			$this->err()->setErrors(_('Divisa: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Data
		if(isset($xmldata->Data) 
			&& $xmldata->Data instanceof SimpleXMLElement
			&& (string) $xmldata->Data != ''
		){
			$this->__set('Data', (string) $xmldata->Data);
		} else{
			
			$this->err()->setErrors(_('Data: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Numero
		if(isset($xmldata->Numero) 
			&& $xmldata->Numero instanceof SimpleXMLElement
			&& (string) $xmldata->Numero != ''
		){
			$this->__set('Numero', (string) $xmldata->Numero);
		} else{
			
			$this->err()->setErrors(_('Numero: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Dati Ritenuta
		if(isset($xmldata->DatiRitenuta)
			&& $xmldata->DatiRitenuta instanceof SimpleXMLElement
		){
			for($k = 0; $k < $xmldata->DatiRitenuta->count(); $k++){
				
				$this->__DatiRitenuta[$k] = $this->DatiRitenuta[$k]
					->loopXml($xmldata->DatiRitenuta[$k]);
			}
		}
	
		// Dati Bollo
		if(isset($xmldata->DatiBollo) 
			&& $xmldata->DatiBollo instanceof SimpleXMLElement
		){
			if($xmldata->DatiBollo->count() == 1){
				
				$this->__DatiBollo = $this->DatiBollo
					->loopXml($xmldata->DatiBollo);
			} else{
				
				$this->err()->setErrors(_('Dati Bollo: Il nodo deve essere presente una sola volta in '.__FILE__.' on line '.__LINE__));
			}
		}
		
		// Dati Cassa Previdenziale
		if(isset($xmldata->DatiCassaPrevidenziale)
			&& $xmldata->DatiCassaPrevidenziale instanceof SimpleXMLElement
		){
			for($k = 0; $k < $xmldata->DatiCassaPrevidenziale->count(); $k++){
				
				$this->__DatiCassaPrevidenziale[$k] = $this->DatiCassaPrevidenziale[$k]
					->loopXml($xmldata->DatiCassaPrevidenziale[$k]);
			}
		}
		
		// Sconto Maggiorazione
		if(isset($xmldata->ScontoMaggiorazione)
			&& $xmldata->ScontoMaggiorazione instanceof SimpleXMLElement
		){
			for($k = 0; $k < $xmldata->ScontoMaggiorazione->count(); $k++){
				
				$this->__ScontoMaggiorazione[$k] = $this->ScontoMaggiorazione[$k]
					->loopXml($xmldata->ScontoMaggiorazione[$k]);
			}
		}
		
		// Importo Totale Documento
		if(isset($xmldata->ImportoTotaleDocumento) 
			&& $xmldata->ImportoTotaleDocumento instanceof SimpleXMLElement
			&& (string) $xmldata->ImportoTotaleDocumento != ''
		){
			$this->__set('ImportoTotaleDocumento', (string) $xmldata->ImportoTotaleDocumento);
		}
		
		// Arrotondamento
		if(isset($xmldata->Arrotondamento) 
			&& $xmldata->Arrotondamento instanceof SimpleXMLElement
			&& (string) $xmldata->Arrotondamento != ''
		){
			$this->__set('Arrotondamento', (string) $xmldata->Arrotondamento);
		}
		
		// Causale
		if(isset($xmldata->Causale)
			&& $xmldata->Causale instanceof SimpleXMLElement
		){
			if($xmldata->Causale->count() > 1){
				
				for($k = 0; $k < $xmldata->Causale->count(); $k++){
					
					$this->__Causale[$k] = (string) $xmldata->Causale[$k];
				}
			} elseif($xmldata->Causale->count() == 1){
				
				$this->__Causale[0] = (string) $xmldata->Causale;
			}
		}
		
		// Art73
		if(isset($xmldata->Art73) 
			&& $xmldata->Art73 instanceof SimpleXMLElement
			&& (string) $xmldata->Art73 != ''
		){
			$this->__set('Art73', (string) $xmldata->Art73);
		}
		
		return $this;
	}
}
