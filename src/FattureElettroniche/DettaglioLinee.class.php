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
use \ArrayAccess;

class DettaglioLinee extends Tag implements ArrayAccess {
	
	use OffsetArray;
	
	/**
	 * Instances
	 * Array di istanze della classe per l'interfaccia ArrayAccess
	 * @var array of object
	 */
	protected $_instances = array();
	
	/**
	 * Numero Linea
	 * Formato numerico; lunghezza massima di 4 caratteri
	 * @var string
	 * @required yes
	 */
	protected $NumeroLinea;
	
	/**
	 * Tipo Cessione Prestazione
	 * Formato alfanumerico; lunghezza di 2 caratteri
	 * @var string
	 * @required no
	 */
	protected $TipoCessionePrestazione;
	
	/**
	 * Codice Articolo
	 * @var object type CodiceArticolo
	 * @required no
	 */
	protected $__CodiceArticolo;
	
	/**
	 * Descrizione
	 * Formato alfanumerico; lunghezza massima di 1000 caratteri
	 * @var string
	 * @required yes
	 */
	protected $Descrizione;
	
	/**
	 * Quantita
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 21 caratteri
	 * @var string
	 * @required no
	 */
	protected $Quantita;
	
	/**
	 * Unita Misura
	 * Formato alfanumerico; lunghezza massima di 10 caratteri
	 * @var string
	 * @required no
	 */
	protected $UnitaMisura;
	
	/**
	 * Data Inizio Periodo
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required no
	 */
	protected $DataInizioPeriodo;
	
	/**
	 * Data Fine Periodo
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required no
	 */
	protected $DataFinePeriodo;
	
	/**
	 * Prezzo Unitario
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 21 caratteri
	 * @var string
	 * @required yes
	 */
	protected $PrezzoUnitario;
	
	/**
	 * Sconto Maggiorazione
	 * @var object type ScontoMaggiorazione
	 * @required no
	 */
	protected $__ScontoMaggiorazione;
	
	/**
	 * Prezzo Totale
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 21 caratteri
	 * @var string
	 * @required yes
	 */
	protected $PrezzoTotale;
	
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
	 * Altri Dati Gestionali
	 * @var object type AltriDatiGestionali
	 * @required no
	 */
	protected $__AltriDatiGestionali;
	
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
				
				// Numero Linea
				if($name == 'NumeroLinea'){
					
					if(!preg_match('/^[0-9]+$/', $value) 
						|| strlen($value) > 4
					){
						
						$this->err()->setErrors(_('Numero Linea "'.$value.'": Formato numerico; lunghezza massima di 4 caratteri in '.$classname));
						return;
					}
				}
				
				// Tipo Cessione Prestazione
				if($name == 'TipoCessionePrestazione'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$TCP[$value])){
						
						$this->err()->setErrors(_('Tipo Cessione Prestazione "'.$value.'": Formato alfanumerico; lunghezza di 2 caratteri in '.$classname));
						return;
					}
				}
				
				// Descrizione
				if($name == 'Descrizione'){
					
					if(!is_string($value) 
						|| strlen($value) > 1000
					){
						
						$this->err()->setErrors(_('Descrizione "'.$value.'": Formato alfanumerico; lunghezza massima di 1000 caratteri in '.$classname));
						return;
					}
				}
					
				// Quantita
				if($name == 'Quantita'){

					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 21
					){
						
						$this->err()->setErrors(_('Quantita "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 21 caratteri in '.$classname));
						return;
					}
				}
				
				// Unita Misura
				if($name == 'UnitaMisura'){
					
					if(!is_string($value) 
						|| strlen($value) > 10
					){
						
						$this->err()->setErrors(_('Unita Misura "'.$value.'": Formato alfanumerico; lunghezza massima di 10 caratteri in '.$classname));
						return;
					}
				}
			
				// Data Inizio Periodo
				if($name == 'DataInizioPeriodo'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						
						$this->err()->setErrors(_('Data Inizio Periodo "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.$classname));
						return;
					}
				}
			
				// Data Fine Periodo
				if($name == 'DataFinePeriodo'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						
						$this->err()->setErrors(_('Data Fine Periodo "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.$classname));
						return;
					}
				}
					
				// Prezzo Unitario
				if($name == 'PrezzoUnitario'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 21
					){
						
						$this->err()->setErrors(_('Prezzo Unitario "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 21 caratteri in '.$classname));
						return;
					}
				}
					
				// Prezzo Totale
				if($name == 'PrezzoTotale'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 21
					){
						
						$this->err()->setErrors(_('Prezzo Totale "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 21 caratteri in '.$classname));
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
					
					if(!isset(Costant::$RTL[$value])){
						
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
				
				// Numero Linea
				if($var->NumeroLinea != ''){
					
					$child = parent::$_dom->createElement('NumeroLinea', $var->NumeroLinea);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Numero Linea: Il tipo è obbligatorio in '.$classname));
				}
				
				// Tipo Cessione Prestazione
				if($var->TipoCessionePrestazione != ''){
					
					$child = parent::$_dom->createElement('TipoCessionePrestazione', $var->TipoCessionePrestazione);
					
					$elem->appendChild($child);
				}
				
				// Codice Articolo
				if($var->__CodiceArticolo instanceof CodiceArticolo){
					
					$childs = $var->__CodiceArticolo->getXml();
					
					if(count($childs)){
						
						foreach($childs as $var2){
							
							if($var2 instanceof DOMNode){
								
								$elem->appendChild($var2);
							}
						}
					}
				}
				
				// Descrizione
				if($var->Descrizione != ''){
					
					$child = parent::$_dom->createElement('Descrizione', $var->Descrizione);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Descrizione: Il tipo è obbligatorio in '.$classname));
				}
				
				// Quantita
				if($var->Quantita != ''){
					
					$child = parent::$_dom->createElement('Quantita', $var->Quantita);
					
					$elem->appendChild($child);
				}
				
				// Unita Misura
				if($var->UnitaMisura != ''){
					
					$child = parent::$_dom->createElement('UnitaMisura', $var->UnitaMisura);
					
					$elem->appendChild($child);
				}
				
				// Data Inizio Periodo
				if($var->DataInizioPeriodo != ''){
					
					$child = parent::$_dom->createElement('DataInizioPeriodo', $var->DataInizioPeriodo);
					
					$elem->appendChild($child);
				}
				
				// Data Fine Periodo
				if($var->DataFinePeriodo != ''){
					
					$child = parent::$_dom->createElement('DataFinePeriodo', $var->DataFinePeriodo);
					
					$elem->appendChild($child);
				}
				
				// Prezzo Unitario
				if($var->PrezzoUnitario != ''){
					
					$child = parent::$_dom->createElement('PrezzoUnitario', $var->PrezzoUnitario);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Prezzo Unitario: Il tipo è obbligatorio in '.$classname));
				}
				
				// Sconto Maggiorazione
				if($var->__ScontoMaggiorazione instanceof ScontoMaggiorazione){
					
					$childs = $var->__ScontoMaggiorazione->getXml();
					
					if(count($childs)){
						
						foreach($childs as $var2){
							
							if($var2 instanceof DOMNode){
	
								$elem->appendChild($var2);
							}
						}
					}
				}
				
				// Prezzo Totale
				if($var->PrezzoTotale != ''){
					
					$child = parent::$_dom->createElement('PrezzoTotale', $var->PrezzoTotale);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Prezzo Totale: Il tipo è obbligatorio in '.$classname));
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
				
				// Altri Dati Gestionali
				if($var->__AltriDatiGestionali instanceof AltriDatiGestionali){
					
					$childs = $var->__AltriDatiGestionali->getXml();
					
					if(count($childs)){
						
						foreach($childs as $var2){
							
							if($var2 instanceof DOMNode){
	
								$elem->appendChild($var2);
							}
						}
					}
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
		
		// Numero Linea
		if(isset($xmldata->NumeroLinea) 
			&& $xmldata->NumeroLinea instanceof SimpleXMLElement
			&& (string) $xmldata->NumeroLinea != ''
		){
			
			$this->__set('NumeroLinea', (string) $xmldata->NumeroLinea);
		} else{
			
			$this->err()->setErrors(_('Numero Linea: Il tipo è obbligatorio in '.$classname));
		}
		
		// Tipo Cessione Prestazione
		if(isset($xmldata->TipoCessionePrestazione) 
			&& $xmldata->TipoCessionePrestazione instanceof SimpleXMLElement
			&& (string) $xmldata->TipoCessionePrestazione != ''
		){
			
			$this->__set('TipoCessionePrestazione', (string) $xmldata->TipoCessionePrestazione);
		}
		
		// Codice Articolo
		if(isset($xmldata->CodiceArticolo)
			&& $xmldata->CodiceArticolo instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->CodiceArticolo->count(); $k++){
				
				$this->__CodiceArticolo[$k] = $this->CodiceArticolo[$k]
					->loopXml($xmldata->CodiceArticolo[$k]);
			}
		}
		
		// Descrizione
		if(isset($xmldata->Descrizione) 
			&& $xmldata->Descrizione instanceof SimpleXMLElement
			&& (string) $xmldata->Descrizione != ''
		){
			
			$this->__set('Descrizione', (string) $xmldata->Descrizione);
		} else{
			
			$this->err()->setErrors(_('Descrizione: Il tipo è obbligatorio in '.$classname));
		}
		
		// Quantita
		if(isset($xmldata->Quantita) 
			&& $xmldata->Quantita instanceof SimpleXMLElement
			&& (string) $xmldata->Quantita != ''
		){
			
			$this->__set('Quantita', (string) $xmldata->Quantita);
		}
		
		// UnitaMisura
		if(isset($xmldata->UnitaMisura) 
			&& $xmldata->UnitaMisura instanceof SimpleXMLElement
			&& (string) $xmldata->UnitaMisura != ''
		){
			
			$this->__set('UnitaMisura', (string) $xmldata->UnitaMisura);
		}
		
		// Data Inizio Periodo
		if(isset($xmldata->DataInizioPeriodo) 
			&& $xmldata->DataInizioPeriodo instanceof SimpleXMLElement
			&& (string) $xmldata->DataInizioPeriodo != ''
		){
			
			$this->__set('DataInizioPeriodo', (string) $xmldata->DataInizioPeriodo);
		}
		
		// Data Fine Periodo
		if(isset($xmldata->DataFinePeriodo) 
			&& $xmldata->DataFinePeriodo instanceof SimpleXMLElement
			&& (string) $xmldata->DataFinePeriodo != ''
		){
			
			$this->__set('DataFinePeriodo', (string) $xmldata->DataFinePeriodo);
		}
		
		// Prezzo Unitario
		if(isset($xmldata->PrezzoUnitario) 
			&& $xmldata->PrezzoUnitario instanceof SimpleXMLElement
			&& (string) $xmldata->PrezzoUnitario != ''
		){
			
			$this->__set('PrezzoUnitario', (string) $xmldata->PrezzoUnitario);
		} else{
			
			$this->err()->setErrors(_('Prezzo Unitario: Il tipo è obbligatorio in '.$classname));
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
		
		// Prezzo Totale
		if(isset($xmldata->PrezzoTotale) 
			&& $xmldata->PrezzoTotale instanceof SimpleXMLElement
			&& (string) $xmldata->PrezzoTotale != ''
		){
			
			$this->__set('PrezzoTotale', (string) $xmldata->PrezzoTotale);
		} else{
			
			$this->err()->setErrors(_('Prezzo Totale: Il tipo è obbligatorio in '.$classname));
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
		
		// Altri Dati Gestionali
		if(isset($xmldata->AltriDatiGestionali)
			&& $xmldata->AltriDatiGestionali instanceof SimpleXMLElement
		){
			
			for($k = 0; $k < $xmldata->AltriDatiGestionali->count(); $k++){
				
				$this->__AltriDatiGestionali[$k] = $this->AltriDatiGestionali[$k]
					->loopXml($xmldata->AltriDatiGestionali[$k]);
			}
		}
		
		return $this;
	}
}