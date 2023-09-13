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

class DettaglioPagamento extends Tag implements ArrayAccess, Iterator, Countable {
	
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
	 * Beneficiario
	 * Formato alfanumerico; lunghezza massima di 200 caratteri
	 * @var string
	 * @required no
	 */
	protected $Beneficiario;
	
	/**
	 * Modalita Pagamento
	 * Formato alfanumerico; lunghezza di 4 caratteri
	 * @var string
	 * @required yes
	 */
	protected $ModalitaPagamento;
	
	/**
	 * Data Riferimento Termini Pagamento
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required no
	 */
	protected $DataRiferimentoTerminiPagamento;
	
	/**
	 * Giorni Termini Pagamento
	 * Formato numerico di lunghezza massima pari a 3. Vale 0 (zero) per pagamenti a vista
	 * @var string
	 * @required no
	 */
	protected $GiorniTerminiPagamento;
	
	/**
	 * Data Scadenza Pagamento
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required no
	 */
	protected $DataScadenzaPagamento;
	
	/**
	 * Importo Pagamento
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required yes
	 */
	protected $ImportoPagamento;
	
	/**
	 * Codice Ufficio Postale
	 * Formato alfanumerico; lunghezza massima di 20 caratteri
	 * @var string
	 * @required no
	 */
	protected $CodUfficioPostale;
	
	/**
	 * Cognome Quietanzante
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required no
	 */
	protected $CognomeQuietanzante;
	
	/**
	 * Nome Quietanzante
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required no
	 */
	protected $NomeQuietanzante;
	
	/**
	 * CF Quietanzante
	 * Formato alfanumerico; lunghezza di 16 caratteri
	 * @var string
	 * @required no
	 */
	protected $CFQuietanzante;
	
	/**
	 * Titolo Quietanzante
	 * Formato alfanumerico; lunghezza che va da 2 a 10 caratteri
	 * @var string
	 * @required no
	 */
	protected $TitoloQuietanzante;
	
	/**
	 * Istituto Finanziario
	 * Formato alfanumerico; lunghezza massima di 80 caratteri
	 * @var string
	 * @required no
	 */
	protected $IstitutoFinanziario;
	
	/**
	 * IBAN
	 * Formato alfanumerico; lunghezza che va da 15 a 34 caratteri
	 * @var string
	 * @required no
	 */
	protected $IBAN;
	
	/**
	 * ABI
	 * Formato numerico di 5 caratteri
	 * @var string
	 * @required no
	 */
	protected $ABI;
	
	/**
	 * CAB
	 * Formato numerico di 5 caratteri
	 * @var string
	 * @required no
	 */
	protected $CAB;
	
	/**
	 * BIC
	 * Formato alfanumerico; lunghezza che va da 8 a 11 caratteri
	 * @var string
	 * @required no
	 */
	protected $BIC;
	
	/**
	 * Sconto Pagamento Anticipato
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $ScontoPagamentoAnticipato;
	
	/**
	 * Data Limite Pagamento Anticipato
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required no
	 */
	protected $DataLimitePagamentoAnticipato;
	
	/**
	 * Penalita Pagamenti Ritardati
	 * Formato numerico nel quale i decimali vanno separati dall'intero con il carattere '.' (punto). La sua lunghezza va da 4 a 15 caratteri
	 * @var string
	 * @required no
	 */
	protected $PenalitaPagamentiRitardati;
	
	/**
	 * Data Decorrenza Penale
	 * La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD
	 * @var string
	 * @required no
	 */
	protected $DataDecorrenzaPenale;
	
	/**
	 * Codice Pagamento
	 * Formato alfanumerico; lunghezza massima di 60 caratteri
	 * @var string
	 * @required no
	 */
	protected $CodicePagamento;
	
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
				
				// Beneficiario
				if($name == 'Beneficiario'){
					
					if(!is_string($value) 
						|| strlen($value) > 200
					){
						$this->err()->setErrors(_('Beneficiario "'.$value.'": Formato alfanumerico; lunghezza massima di 200 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Modalita Pagamento
				if($name == 'ModalitaPagamento'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!isset(Costant::$MP[$value])){
						
						$this->err()->setErrors(_('Modalita Pagamento "'.$value.'": Formato alfanumerico; lunghezza da 2 a 4 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
			
				// Data Riferimento Termini Pagamento
				if($name == 'DataRiferimentoTerminiPagamento'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						$this->err()->setErrors(_('Data Riferimento Termini Pagamento "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Giorni Termini Pagamento
				if($name == 'GiorniTerminiPagamento'){
					
					if(!preg_match('/^\d+$/', $value) 
						|| strlen($value) > 3
					){
						$this->err()->setErrors(_('Giorni Termini Pagamento "'.$value.'": Formato numerico; lunghezza massima di 3 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
			
				// Data Scadenza Pagamento
				if($name == 'DataScadenzaPagamento'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						$this->err()->setErrors(_('Data Scadenza Pagamento "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
					
				// Importo Pagamento
				if($name == 'ImportoPagamento'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						$this->err()->setErrors(_('Importo Pagamento "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Codice Ufficio Postale
				if($name == 'CodUfficioPostale'){
					
					if(!is_string($value) 
						|| strlen($value) > 20
					){
						$this->err()->setErrors(_('Codice Ufficio Postale "'.$value.'": Formato alfanumerico; lunghezza massima di 20 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Cognome Quietanzante
				if($name == 'CognomeQuietanzante'){
					
					if(!is_string($value) 
						|| strlen($value) > 60
					){
						$this->err()->setErrors(_('Cognome Quietanzante "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Nome Quietanzante
				if($name == 'NomeQuietanzante'){
					
					if(!is_string($value) 
						|| strlen($value) > 60
					){
						$this->err()->setErrors(_('Nome Quietanzante "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// CF Quietanzante
				if($name == 'CFQuietanzante'){
					
					if(!preg_match('/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9A-Z]{3}[A-Z]$/i', $value) 
						|| strlen($value) > 16
					){
						$this->err()->setErrors(_('CF Quietanzante "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Titolo Quietanzante
				if($name == 'TitoloQuietanzante'){
					
					if(!is_string($value) 
						|| strlen($value) < 2 
						|| strlen($value) > 10
					){
						$this->err()->setErrors(_('Titolo Quietanzante "'.$value.'": Formato alfanumerico; lunghezza che va da 2 a 10 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Istituto Finanziario
				if($name == 'IstitutoFinanziario'){
					
					if(!is_string($value) 
						|| strlen($value) > 80
					){
						$this->err()->setErrors(_('Istituto Finanziario "'.$value.'": Formato alfanumerico; lunghezza massima di 80 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// IBAN
				if($name == 'IBAN'){
					
					if(!is_string($value) 
						|| strlen($value) < 15 
						|| strlen($value) > 34
					){
						$this->err()->setErrors(_('IBAN "'.$value.'": Formato alfanumerico; lunghezza che va da 2 a 10 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// ABI
				if($name == 'ABI'){
					
					if(!preg_match('/^[0-9]+$/', $value) 
						|| strlen($value) != 5
					){
						$this->err()->setErrors(_('ABI "'.$value.'": Formato numerico; lunghezza di 5 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// CAB
				if($name == 'CAB'){
					
					if(!preg_match('/^[0-9]+$/', $value) 
						|| strlen($value) != 5
					){
						$this->err()->setErrors(_('CAB "'.$value.'": Formato numerico; lunghezza di 5 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// BIC
				if($name == 'BIC'){
					
					$value = mb_strtoupper($value, 'UTF-8');
					
					if(!preg_match('/^[0-9A-Z]+$/', $value) 
						|| strlen($value) < 8 
						|| strlen($value) > 11
					){
						$this->err()->setErrors(_('BIC "'.$value.'": Formato alfanumerico; lunghezza che va da 8 a 11 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
					
				// Sconto Pagamento Anticipato
				if($name == 'ScontoPagamentoAnticipato'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						$this->err()->setErrors(_('Sconto Pagamento Anticipato "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
			
				// Data Limite Pagamento Anticipato
				if($name == 'DataLimitePagamentoAnticipato'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						$this->err()->setErrors(_('Data Limite Pagamento Anticipato "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
					
				// Penalita Pagamenti Ritardati
				if($name == 'PenalitaPagamentiRitardati'){
					
					if(!preg_match('/^(?=.)(([0-9]+)(\.([0-9]+))?)$/', $value) 
						|| strlen($value) < 4 
						|| strlen($value) > 15
					){
						$this->err()->setErrors(_('Penalita Pagamenti Ritardati "'.$value.'": Formato numerico nel quale i decimali vanno separati dall\'intero con il carattere \'.\' (punto). La sua lunghezza va da 4 a 15 caratteri in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
			
				// Data Decorrenza Penale
				if($name == 'DataDecorrenzaPenale'){
					
					if(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $value) 
						|| strlen($value) != 10
					){
						$this->err()->setErrors(_('Data Decorrenza Penale "'.$value.'": La data deve essere rappresentata secondo il formato ISO 8601:2004, con la seguente precisione: YYYY-MM-DD in '.__FILE__.' on line '.__LINE__));
						return;
					}
				}
				
				// Codice Pagamento
				if($name == 'CodicePagamento'){
					
					if(!is_string($value) 
						|| strlen($value) > 60
					){
						$this->err()->setErrors(_('Codice Pagamento "'.$value.'": Formato alfanumerico; lunghezza massima di 60 caratteri in '.__FILE__.' on line '.__LINE__));
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
				
				// Beneficiario
				if($var->Beneficiario != ''){
					
					$child = parent::$_dom->createElement('Beneficiario', $var->Beneficiario);
					
					$elem->appendChild($child);
				}
				
				// Modalita Pagamento
				if($var->ModalitaPagamento != ''){
					
					$child = parent::$_dom->createElement('ModalitaPagamento', $var->ModalitaPagamento);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Modalita Pagamento: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
				}
				
				// Data Riferimento Termini Pagamento
				if($var->DataRiferimentoTerminiPagamento != ''){
					
					$child = parent::$_dom->createElement('DataRiferimentoTerminiPagamento', $var->DataRiferimentoTerminiPagamento);
					
					$elem->appendChild($child);
				}
				
				// Giorni Termini Pagamento
				if($var->GiorniTerminiPagamento != ''){
					
					$child = parent::$_dom->createElement('GiorniTerminiPagamento', $var->GiorniTerminiPagamento);
					
					$elem->appendChild($child);
				}
				
				// Data Scadenza Pagamento
				if($var->DataScadenzaPagamento != ''){
					
					$child = parent::$_dom->createElement('DataScadenzaPagamento', $var->DataScadenzaPagamento);
					
					$elem->appendChild($child);
				}
				
				// Importo Pagamento
				if($var->ImportoPagamento != ''){
					
					$child = parent::$_dom->createElement('ImportoPagamento', $var->ImportoPagamento);
					
					$elem->appendChild($child);
				} else{
					
					$this->err()->setErrors(_('Importo Pagamento: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
				}
				
				// Codice Ufficio Postale
				if($var->CodUfficioPostale != ''){
					
					$child = parent::$_dom->createElement('CodUfficioPostale', $var->CodUfficioPostale);
					
					$elem->appendChild($child);
				}
				
				// Cognome Quietanzante
				if($var->CognomeQuietanzante != ''){
					
					$child = parent::$_dom->createElement('CognomeQuietanzante', $var->CognomeQuietanzante);
					
					$elem->appendChild($child);
				}
				
				// Nome Quietanzante
				if($var->NomeQuietanzante != ''){
					
					$child = parent::$_dom->createElement('NomeQuietanzante', $var->NomeQuietanzante);
					
					$elem->appendChild($child);
				}
				
				// CF Quietanzante
				if($var->CFQuietanzante != ''){
					
					$child = parent::$_dom->createElement('CFQuietanzante', $var->CFQuietanzante );
					
					$elem->appendChild($child);
				}
				
				// Titolo Quietanzante
				if($var->TitoloQuietanzante != ''){
					
					$child = parent::$_dom->createElement('TitoloQuietanzante', $var->TitoloQuietanzante);
					
					$elem->appendChild($child);
				}
				
				// Istituto Finanziario
				if($var->IstitutoFinanziario != ''){
					
					$child = parent::$_dom->createElement('IstitutoFinanziario', $var->IstitutoFinanziario);
					
					$elem->appendChild($child);
				}
				
				// IBAN
				if($var->IBAN != ''){
					
					$child = parent::$_dom->createElement('IBAN', $var->IBAN);
					
					$elem->appendChild($child);
				}
				
				// ABI
				if($var->ABI != ''){
					
					$child = parent::$_dom->createElement('ABI', $var->ABI);
					
					$elem->appendChild($child);
				}
				
				// CAB
				if($var->CAB != ''){
					
					$child = parent::$_dom->createElement('CAB', $var->CAB);
					
					$elem->appendChild($child);
				}
				
				// BIC
				if($var->BIC != ''){
					
					$child = parent::$_dom->createElement('BIC', $var->BIC);
					
					$elem->appendChild($child);
				}
				
				// Sconto Pagamento Anticipato
				if($var->ScontoPagamentoAnticipato != ''){
					
					$child = parent::$_dom->createElement('ScontoPagamentoAnticipato', $var->ScontoPagamentoAnticipato);
					
					$elem->appendChild($child);
				}
				
				// Data Limite Pagamento Anticipato
				if($var->DataLimitePagamentoAnticipato != ''){
					
					$child = parent::$_dom->createElement('DataLimitePagamentoAnticipato', $var->DataLimitePagamentoAnticipato);
					
					$elem->appendChild($child);
				}
				
				// Penalita Pagamenti Ritardati
				if($var->PenalitaPagamentiRitardati != ''){
					
					$child = parent::$_dom->createElement('PenalitaPagamentiRitardati', $var->PenalitaPagamentiRitardati);
					
					$elem->appendChild($child);
				}
				
				// Data Decorrenza Penale
				if($var->DataDecorrenzaPenale != ''){
					
					$child = parent::$_dom->createElement('DataDecorrenzaPenale', $var->DataDecorrenzaPenale);
					
					$elem->appendChild($child);
				}
				
				// Codice Pagamento
				if($var->CodicePagamento != ''){
					
					$child = parent::$_dom->createElement('CodicePagamento', $var->CodicePagamento);
					
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
		
		// Beneficiario
		if(isset($xmldata->Beneficiario) 
			&& $xmldata->Beneficiario instanceof SimpleXMLElement
			&& (string) $xmldata->Beneficiario != ''
		){
			$this->__set('Beneficiario', (string) $xmldata->Beneficiario);
		}
		
		// Modalita Pagamento
		if(isset($xmldata->ModalitaPagamento) 
			&& $xmldata->ModalitaPagamento instanceof SimpleXMLElement
			&& (string) $xmldata->ModalitaPagamento != ''
		){
			$this->__set('ModalitaPagamento', (string) $xmldata->ModalitaPagamento);
		} else{
			
			$this->err()->setErrors(_('Modalita Pagamento: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Data Riferimento Termini Pagamento
		if(isset($xmldata->DataRiferimentoTerminiPagamento) 
			&& $xmldata->DataRiferimentoTerminiPagamento instanceof SimpleXMLElement
			&& (string) $xmldata->DataRiferimentoTerminiPagamento != ''
		){
			$this->__set('DataRiferimentoTerminiPagamento', (string) $xmldata->DataRiferimentoTerminiPagamento);
		}
		
		// Giorni Termini Pagamento
		if(isset($xmldata->GiorniTerminiPagamento) 
			&& $xmldata->GiorniTerminiPagamento instanceof SimpleXMLElement
			&& (string) $xmldata->GiorniTerminiPagamento != ''
		){
			$this->__set('GiorniTerminiPagamento', (string) $xmldata->GiorniTerminiPagamento);
		}
		
		// Data Scadenza Pagamento
		if(isset($xmldata->DataScadenzaPagamento) 
			&& $xmldata->DataScadenzaPagamento instanceof SimpleXMLElement
			&& (string) $xmldata->DataScadenzaPagamento != ''
		){
			$this->__set('DataScadenzaPagamento', (string) $xmldata->DataScadenzaPagamento);
		}
		
		// Importo Pagamento
		if(isset($xmldata->ImportoPagamento) 
			&& $xmldata->ImportoPagamento instanceof SimpleXMLElement
			&& (string) $xmldata->ImportoPagamento != ''
		){
			$this->__set('ImportoPagamento', (string) $xmldata->ImportoPagamento);
		} else{
			
			$this->err()->setErrors(_('Importo Pagamento: Il tipo è obbligatorio in '.__FILE__.' on line '.__LINE__));
		}
		
		// Codice Ufficio Postale
		if(isset($xmldata->CodUfficioPostale) 
			&& $xmldata->CodUfficioPostale instanceof SimpleXMLElement
			&& (string) $xmldata->CodUfficioPostale != ''
		){
			$this->__set('CodUfficioPostale', (string) $xmldata->CodUfficioPostale);
		}
		
		// Cognome Quietanzante
		if(isset($xmldata->CognomeQuietanzante) 
			&& $xmldata->CognomeQuietanzante instanceof SimpleXMLElement
			&& (string) $xmldata->CognomeQuietanzante != ''
		){
			$this->__set('CognomeQuietanzante', (string) $xmldata->CognomeQuietanzante);
		}
		
		// Nome Quietanzante
		if(isset($xmldata->NomeQuietanzante) 
			&& $xmldata->NomeQuietanzante instanceof SimpleXMLElement
			&& (string) $xmldata->NomeQuietanzante != ''
		){
			$this->__set('NomeQuietanzante', (string) $xmldata->NomeQuietanzante);
		}
		
		// CF Quietanzante
		if(isset($xmldata->CFQuietanzante) 
			&& $xmldata->CFQuietanzante instanceof SimpleXMLElement
			&& (string) $xmldata->CFQuietanzante != ''
		){
			$this->__set('CFQuietanzante', (string) $xmldata->CFQuietanzante);
		}
		
		// Titolo Quietanzante
		if(isset($xmldata->TitoloQuietanzante) 
			&& $xmldata->TitoloQuietanzante instanceof SimpleXMLElement
			&& (string) $xmldata->TitoloQuietanzante != ''
		){
			$this->__set('TitoloQuietanzante', (string) $xmldata->TitoloQuietanzante);
		}
		
		// Istituto Finanziario
		if(isset($xmldata->IstitutoFinanziario) 
			&& $xmldata->IstitutoFinanziario instanceof SimpleXMLElement
			&& (string) $xmldata->IstitutoFinanziario != ''
		){
			$this->__set('IstitutoFinanziario', (string) $xmldata->IstitutoFinanziario);
		}
		
		// IBAN
		if(isset($xmldata->IBAN) 
			&& $xmldata->IBAN instanceof SimpleXMLElement
			&& (string) $xmldata->IBAN != ''
		){
			$this->__set('IBAN', (string) $xmldata->IBAN);
		}
		
		// ABI
		if(isset($xmldata->ABI) 
			&& $xmldata->ABI instanceof SimpleXMLElement
			&& (string) $xmldata->ABI != ''
		){
			$this->__set('ABI', (string) $xmldata->ABI);
		}
		
		// CAB
		if(isset($xmldata->CAB) 
			&& $xmldata->CAB instanceof SimpleXMLElement
			&& (string) $xmldata->CAB != ''
		){
			$this->__set('CAB', (string) $xmldata->CAB);
		}
		
		// BIC
		if(isset($xmldata->BIC) 
			&& $xmldata->BIC instanceof SimpleXMLElement
			&& (string) $xmldata->BIC != ''
		){
			$this->__set('BIC', (string) $xmldata->BIC);
		}
		
		// Sconto Pagamento Anticipato
		if(isset($xmldata->ScontoPagamentoAnticipato) 
			&& $xmldata->ScontoPagamentoAnticipato instanceof SimpleXMLElement
			&& (string) $xmldata->ScontoPagamentoAnticipato != ''
		){
			$this->__set('ScontoPagamentoAnticipato', (string) $xmldata->ScontoPagamentoAnticipato);
		}
		
		// Data Limite Pagamento Anticipato
		if(isset($xmldata->DataLimitePagamentoAnticipato) 
			&& $xmldata->DataLimitePagamentoAnticipato instanceof SimpleXMLElement
			&& (string) $xmldata->DataLimitePagamentoAnticipato != ''
		){
			$this->__set('DataLimitePagamentoAnticipato', (string) $xmldata->DataLimitePagamentoAnticipato);
		}
		
		// Penalita Pagamenti Ritardati
		if(isset($xmldata->PenalitaPagamentiRitardati) 
			&& $xmldata->PenalitaPagamentiRitardati instanceof SimpleXMLElement
			&& (string) $xmldata->PenalitaPagamentiRitardati != ''
		){
			$this->__set('PenalitaPagamentiRitardati', (string) $xmldata->PenalitaPagamentiRitardati);
		}
		
		// Data Decorrenza Penale
		if(isset($xmldata->DataDecorrenzaPenale) 
			&& $xmldata->DataDecorrenzaPenale instanceof SimpleXMLElement
			&& (string) $xmldata->DataDecorrenzaPenale != ''
		){
			$this->__set('DataDecorrenzaPenale', (string) $xmldata->DataDecorrenzaPenale);
		}
		
		// Codice Pagamento
		if(isset($xmldata->CodicePagamento) 
			&& $xmldata->CodicePagamento instanceof SimpleXMLElement
			&& (string) $xmldata->CodicePagamento != ''
		){
			$this->__set('CodicePagamento', (string) $xmldata->CodicePagamento);
		}
		
		return $this;
	}
}
