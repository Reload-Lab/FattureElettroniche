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
use \DOMNode;

class DatiTrasporto extends Tag {
	
	/**
	 * Dati Anagrafici Vettore
	 * @var object type DatiAnagraficiVettore
	 * @required no
	 */
	protected $__DatiAnagraficiVettore;
	
	/**
	 * Mezzo Trasporto
	 * Formato alfanumerico; lunghezza massima di 80 caratteri
	 * @var string
	 * @required no
	 */
	protected $MezzoTrasporto;
	
	/**
	 * Causale Trasporto
	 * Formato alfanumerico; lunghezza massima di 100 caratteri
	 * @var string
	 * @required no
	 */
	protected $CausaleTrasporto;
	
	/**
	 * Numero Colli
	 * Formato numerico; lunghezza massima di 4 caratteri
	 * @var string
	 * @required no
	 */
	protected $NumeroColli;
	
	/**
	 * Descrizione
	 * Formato alfanumerico; lunghezza massima di 100 caratteri
	 * @var string
	 * @required no
	 */
	protected $Descrizione;
	
	/**
	 * Unita Misura Peso
	 * Formato alfanumerico; lunghezza massima di 10 caratteri
	 * @var string
	 * @required no
	 */
	protected $UnitaMisuraPeso;
	
	/**
	 * Peso Lordo
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 7 caratteri
	 * @var string
	 * @required no
	 */
	protected $PesoLordo;
	
	/**
	 * Peso Netto
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 7 caratteri
	 * @var string
	 * @required no
	 */
	protected $PesoNetto;
	
	/**
	 * Data Ora Ritiro
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DDTHH:MM:SS
	 * @var string
	 * @required no
	 */
	protected $DataOraRitiro;
	
	/**
	 * Data Inizio Trasporto
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required no
	 */
	protected $DataInizioTrasporto;
	
	/**
	 * Tipo Resa
	 * Codifica del termine di resa (Incoterms) espresso secondo lo standard ICC-Camera di Commercio Internazionale (formato alfanumerico di 3 caratteri)
	 * @var string
	 * @required no
	 */
	protected $TipoResa;
	
	/**
	 * Indirizzo Resa
	 * @var object type IndirizzoResa
	 * @required no
	 */
	protected $__IndirizzoResa;
	
	/**
	 * Data Ora Consegna
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DDTHH:MM:SS
	 * @var string
	 * @required no
	 */
	protected $DataOraConsegna;
	
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
				
				// Mezzo Trasporto
				if($name == 'MezzoTrasporto'){
					
					if(!is_string($value) 
						|| strlen($value) > 80
					){
						
						$this->err()->setErrors(_('Mezzo Trasporto "'.$value.'": Formato alfanumerico; lunghezza massima di 80 caratteri in '.$classname));
						return;
					}
				}
				
				// Causale Trasporto
				if($name == 'CausaleTrasporto'){
					
					if(!is_string($value) 
						|| strlen($value) > 100
					){
						
						$this->err()->setErrors(_('Causale Trasporto "'.$value.'": Formato alfanumerico; lunghezza massima di 100 caratteri in '.$classname));
						return;
					}
				}
				
				// Numero Colli
				if($name == 'NumeroColli'){
					
					if(!preg_match('/^\d+$/', $value) 
						|| strlen($value) > 4
					){
						
						$this->err()->setErrors(_('Numero Colli "'.$value.'": Formato numerico; lunghezza massima di 4 caratteri in '.$classname));
						return;
					}
				}
				
				// Descrizione
				if($name == 'Descrizione'){
					
					if(!is_string($value) 
						|| strlen($value) > 100
					){
						
						$this->err()->setErrors(_('Descrizione "'.$value.'": Formato alfanumerico; lunghezza massima di 100 caratteri in '.$classname));
						return;
					}
				}
				
				// Unita Misura Peso
				if($name == 'UnitaMisuraPeso'){
					
					if(!is_string($value) 
						|| strlen($value) > 10
					){
						
						$this->err()->setErrors(_('Unita Misura Peso "'.$value.'": Formato alfanumerico; lunghezza massima di 10 caratteri in '.$classname));
						return;
					}
				}
					
				// Peso Lordo
				if($name == 'PesoLordo'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 7
					){
						
						$this->err()->setErrors(_('Peso Lordo "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 7 caratteri in '.$classname));
						return;
					}
				}
					
				// Peso Netto
				if($name == 'PesoNetto'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 7
					){
						
						$this->err()->setErrors(_('Peso Netto "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 7 caratteri in '.$classname));
						return;
					}
				}
			
				// Data Ora Ritiro
				if($name == 'DataOraRitiro'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]) (2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/', $value) 
						|| strlen($value) != 19
					){
						
						$this->err()->setErrors(_('Data Ora Ritiro "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DDTHH:MM:SS in '.$classname));
						return;
					}
				}
			
				// Data Inizio Trasporto
				if($name == 'DataInizioTrasporto'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						
						$this->err()->setErrors(_('Data Inizio Trasporto "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.$classname));
						return;
					}
				}
				
				// Tipo Resa
				if($name == 'TipoResa'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!preg_match('/^[0-1A-Z]+$/', $value) 
						|| strlen($value) != 3
					){
						
						$this->err()->setErrors(_('Tipo Resa "'.$value.'": Codifica del termine di resa (Incoterms) espresso secondo lo standard ICC-Camera di Commercio Internazionale (formato alfanumerico di 3 caratteri) in '.$classname));
						return;
					}
				}
			
				// Data Ora Consegna
				if($name == 'DataOraConsegna'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]) (2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/', $value) 
						|| strlen($value) != 19
					){
						
						$this->err()->setErrors(_('Data Ora Consegna "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DDTHH:MM:SS in '.$classname));
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
		
		// Dati Anagrafici Vettore
		if($this->__DatiAnagraficiVettore instanceof DatiAnagraficiVettore){
			
			$child = $this->__DatiAnagraficiVettore->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		}
		
		// Mezzo Trasporto
		if($this->MezzoTrasporto != ''){
			
			$child = parent::$_dom->createElement('MezzoTrasporto', $this->MezzoTrasporto);
			
			$elem->appendChild($child);
		}
		
		// Causale Trasporto
		if($this->CausaleTrasporto != ''){
			
			$child = parent::$_dom->createElement('CausaleTrasporto', $this->CausaleTrasporto);
			
			$elem->appendChild($child);
		}
		
		// Numero Colli
		if($this->NumeroColli != ''){
			
			$child = parent::$_dom->createElement('NumeroColli', $this->NumeroColli);
			
			$elem->appendChild($child);
		}
		
		// Descrizione
		if($this->Descrizione != ''){
			
			$child = parent::$_dom->createElement('Descrizione', $this->Descrizione);
			
			$elem->appendChild($child);
		}
		
		// Unita Misura Peso
		if($this->UnitaMisuraPeso != ''){
			
			$child = parent::$_dom->createElement('UnitaMisuraPeso', $this->UnitaMisuraPeso);
			
			$elem->appendChild($child);
		}
		
		// Peso Lordo
		if($this->PesoLordo != ''){
			
			$child = parent::$_dom->createElement('PesoLordo', $this->PesoLordo);
			
			$elem->appendChild($child);
		}
		
		// Peso Netto
		if($this->PesoNetto != ''){
			
			$child = parent::$_dom->createElement('PesoNetto', $this->PesoNetto);
			
			$elem->appendChild($child);
		}
		
		// Data Ora Ritiro
		if($this->DataOraRitiro != ''){
			
			$child = parent::$_dom->createElement('DataOraRitiro', $this->DataOraRitiro);
			
			$elem->appendChild($child);
		}
		
		// Data Inizio Trasporto
		if($this->DataInizioTrasporto != ''){
			
			$child = parent::$_dom->createElement('DataInizioTrasporto', $this->DataInizioTrasporto);
			
			$elem->appendChild($child);
		}
		
		// Tipo Resa
		if($this->TipoResa != ''){
			
			$child = parent::$_dom->createElement('TipoResa', $this->TipoResa);
			
			$elem->appendChild($child);
		}
		
		// Indirizzo Resa
		if($this->__IndirizzoResa instanceof IndirizzoResa){
			
			$child = $this->__IndirizzoResa->getXml();
			
			if($child instanceof DOMNode){
	
				$elem->appendChild($child);
			}
		}
		
		// Data Ora Consegna
		if($this->DataOraConsegna != ''){
			
			$child = parent::$_dom->createElement('DataOraConsegna', $this->DataOraConsegna);
			
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
		
		// Dati Anagrafici Vettore
		if(isset($xmldata->DatiAnagraficiVettore) 
			&& $xmldata->DatiAnagraficiVettore instanceof SimpleXMLElement
		){
			
			if($xmldata->DatiAnagraficiVettore->count() == 1){
				
				$this->__DatiAnagraficiVettore = $this->DatiAnagraficiVettore
					->loopXml($xmldata->DatiAnagraficiVettore);
			} else{
				
				$this->err()->setErrors(_('Dati Anagrafici Vettore: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}
		
		// Mezzo Trasporto
		if(isset($xmldata->MezzoTrasporto) 
			&& $xmldata->MezzoTrasporto instanceof SimpleXMLElement
			&& (string) $xmldata->MezzoTrasporto != ''
		){
			
			$this->__set('MezzoTrasporto', (string) $xmldata->MezzoTrasporto);
		}
		
		// Causale Trasporto
		if(isset($xmldata->CausaleTrasporto) 
			&& $xmldata->CausaleTrasporto instanceof SimpleXMLElement
			&& (string) $xmldata->CausaleTrasporto != ''
		){
			
			$this->__set('CausaleTrasporto', (string) $xmldata->CausaleTrasporto);
		}
		
		// Numero Colli
		if(isset($xmldata->NumeroColli) 
			&& $xmldata->NumeroColli instanceof SimpleXMLElement
			&& (string) $xmldata->NumeroColli != ''
		){
			
			$this->__set('NumeroColli', (string) $xmldata->NumeroColli);
		}
		
		// Descrizione
		if(isset($xmldata->Descrizione) 
			&& $xmldata->Descrizione instanceof SimpleXMLElement
			&& (string) $xmldata->Descrizione != ''
		){
			
			$this->__set('Descrizione', (string) $xmldata->Descrizione);
		}
		
		// Unita Misura Peso
		if(isset($xmldata->UnitaMisuraPeso) 
			&& $xmldata->UnitaMisuraPeso instanceof SimpleXMLElement
			&& (string) $xmldata->UnitaMisuraPeso != ''
		){
			
			$this->__set('UnitaMisuraPeso', (string) $xmldata->UnitaMisuraPeso);
		}
		
		// Peso Lordo
		if(isset($xmldata->PesoLordo) 
			&& $xmldata->PesoLordo instanceof SimpleXMLElement
			&& (string) $xmldata->PesoLordo != ''
		){
			
			$this->__set('PesoLordo', (string) $xmldata->PesoLordo);
		}
		
		// Data Ora Ritiro
		if(isset($xmldata->DataOraRitiro) 
			&& $xmldata->DataOraRitiro instanceof SimpleXMLElement
			&& (string) $xmldata->DataOraRitiro != ''
		){
			
			$this->__set('DataOraRitiro', (string) $xmldata->DataOraRitiro);
		}
		
		// Data Inizio Trasporto
		if(isset($xmldata->DataInizioTrasporto) 
			&& $xmldata->DataInizioTrasporto instanceof SimpleXMLElement
			&& (string) $xmldata->DataInizioTrasporto != ''
		){
			
			$this->__set('DataInizioTrasporto', (string) $xmldata->DataInizioTrasporto);
		}
		
		// Tipo Resa
		if(isset($xmldata->TipoResa) 
			&& $xmldata->TipoResa instanceof SimpleXMLElement
			&& (string) $xmldata->TipoResa != ''
		){
			
			$this->__set('TipoResa', (string) $xmldata->TipoResa);
		}
	
		// Indirizzo Resa
		if(isset($xmldata->IndirizzoResa) 
			&& $xmldata->IndirizzoResa instanceof SimpleXMLElement
		){
			
			if($xmldata->IndirizzoResa->count() == 1){
				
				$this->__IndirizzoResa = $this->IndirizzoResa
					->loopXml($xmldata->IndirizzoResa);
			} else{
				
				$this->err()->setErrors(_('Indirizzo Resa: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}
		
		// Data Ora Consegna
		if(isset($xmldata->DataOraConsegna) 
			&& $xmldata->DataOraConsegna instanceof SimpleXMLElement
			&& (string) $xmldata->DataOraConsegna != ''
		){
			
			$this->__set('DataOraConsegna', (string) $xmldata->DataOraConsegna);
		}
		
		return $this;
	}
}