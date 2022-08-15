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

class DatiTrasmissione extends Tag {
	
	/**
	 * Id Trasmittente
	 * @var object type IdTrasmittente
	 * @required yes
	 */
	protected $__IdTrasmittente;
	
	/**
	 * Progressivo Invio
	 * Formato alfanumerico; lunghezza massima di 10 caratteri
	 * @var string
	 * @required yes
	 */
	protected $ProgressivoInvio;
	
	/**
	 * Formato Trasmissione
	 * Formato alfanumerico; lunghezza di 5 caratteri
	 * @var string
	 * @required yes
	 */
	protected $FormatoTrasmissione = 'FPR12';
	
	/**
	 * Codice Destinatario
	 * Formato alfanumerico; lunghezza di 7 caratteri
	 * @var string
	 * @required yes
	 */
	protected $CodiceDestinatario;
	
	/**
	 * Contatti Trasmittente
	 * @var object type ContattiTrasmittente
	 * @required no
	 */
	protected $__ContattiTrasmittente;
	
	/**
	 * PEC Destinatario
	 * Formato alfanumerico; lunghezza che va da 7 a 256 caratteri
	 * @var string
	 * @required no
	 */
	protected $PECDestinatario;
	
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
				
				// Progressivo Invio
				if($name == 'ProgressivoInvio'){
					
					if(!preg_match('/^[a-zA-Z0-9]+$/', $value) 
						|| strlen($value) > 10
					){
						
						$this->err()->setErrors(_('Progressivo Invio "'.$value.'": Formato alfanumerico; lunghezza massima di 10 caratteri in '.$classname));
						return;
					}
				}
				
				// Formato Trasmissione
				if($name == 'FormatoTrasmissione'){
					
					if(!preg_match('/^[a-zA-Z0-9]+$/', $value) 
						|| strlen($value) != 5
					){
						
						$this->err()->setErrors(_('Formato Trasmissione "'.$value.'": Formato alfanumerico; lunghezza di 5 caratteri in '.$classname));
						return;
					}
				}
				
				// Codice Destinatario
				if($name == 'CodiceDestinatario'){
					
					if(!preg_match('/^[a-zA-Z0-9]+$/', $value) 
						|| strlen($value) != 7
					){
						
						$this->err()->setErrors(_('Codice Destinatario "'.$value.'": Formato alfanumerico; lunghezza di 7 caratteri in '.$classname));
						return;
					}
				}
				
				// PEC Destinatario
				if($name == 'PECDestinatario'){
					
					if(!is_string($value) 
						|| strlen($value) < 7 
						|| strlen($value) > 256
					){
						
						$this->err()->setErrors(_('PEC Destinatario "'.$value.'": Formato alfanumerico; lunghezza che va da 7 a 256 caratteri in '.$classname));
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
		
		// Id Trasmittente
		if($this->__IdTrasmittente instanceof IdTrasmittente){
			
			$child = $this->__IdTrasmittente->getXml();
			
			if($child instanceof DOMNode){
				
				$elem->appendChild($child);
			}
		} else{
			
			$this->err()->setErrors(_('Id Trasmittente: Il tipo complesso è obbligatorio in '.$classname));
		}
		
		// Progressivo Invio
		if($this->ProgressivoInvio != ''){
			
			$child = parent::$_dom->createElement('ProgressivoInvio', $this->ProgressivoInvio);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Progressivo Invio: Il tipo è obbligatorio in '.$classname));
		}
		
		// Formato Trasmissione
		if($this->FormatoTrasmissione != ''){
			
			$child = parent::$_dom->createElement('FormatoTrasmissione', $this->FormatoTrasmissione);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Formato Trasmissione: Il tipo è obbligatorio in '.$classname));
		}
		
		// Codice Destinatario
		if($this->CodiceDestinatario != ''){
			
			$child = parent::$_dom->createElement('CodiceDestinatario', $this->CodiceDestinatario);
			
			$elem->appendChild($child);
		} else{
			
			$this->err()->setErrors(_('Codice Destinatario: Il tipo è obbligatorio in '.$classname));
		}
		
		// Contatti Trasmittente
		if($this->__ContattiTrasmittente instanceof ContattiTrasmittente){
			
			$child = $this->__ContattiTrasmittente->getXml();
			
			if($child instanceof DOMNode){
				
				$elem->appendChild($child);
			}
		}
		
		// PEC Destinatario
		if($this->PECDestinatario != ''){
			
			$child = parent::$_dom->createElement('PECDestinatario', $this->PECDestinatario);
			
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
		
		// Id Trasmittente
		if(isset($xmldata->IdTrasmittente) 
			&& $xmldata->IdTrasmittente instanceof SimpleXMLElement
		){
			
			if($xmldata->IdTrasmittente->count() == 1){
				
				$this->__IdTrasmittente = $this->IdTrasmittente
					->loopXml($xmldata->IdTrasmittente);
			} else{
				
				$this->err()->setErrors(_('Id Trasmittente: Il nodo deve essere presente una sola volta in '.$classname));
			}
		} else{
			
			$this->err()->setErrors(_('Id Trasmittente: Il tipo complesso è obbligatorio in '.$classname));
		}

		// Progressivo Invio
		if(isset($xmldata->ProgressivoInvio) 
			&& $xmldata->ProgressivoInvio instanceof SimpleXMLElement
			&& (string) $xmldata->ProgressivoInvio != ''
		){
			
			$this->__set('ProgressivoInvio', (string) $xmldata->ProgressivoInvio);
		} else{
			
			$this->err()->setErrors(_('Progressivo Invio: Il tipo è obbligatorio in '.$classname));
		}
		
		// Formato Trasmissione
		if(isset($xmldata->FormatoTrasmissione) 
			&& $xmldata->FormatoTrasmissione instanceof SimpleXMLElement
			&& (string) $xmldata->FormatoTrasmissione != ''
		){
			
			$this->__set('FormatoTrasmissione', (string) $xmldata->FormatoTrasmissione);
		} else{
			
			$this->err()->setErrors(_('Formato Trasmissione: Il tipo è obbligatorio in '.$classname));
		}
		
		// Codice Destinatario
		if(isset($xmldata->CodiceDestinatario) 
			&& $xmldata->CodiceDestinatario instanceof SimpleXMLElement
			&& (string) $xmldata->CodiceDestinatario != ''
		){
			
			$this->__set('CodiceDestinatario', (string) $xmldata->CodiceDestinatario);
		} else{
			
			$this->err()->setErrors(_('Codice Destinatario: Il tipo è obbligatorio in '.$classname));
		}
		
		// Contatti Trasmittente
		if(isset($xmldata->ContattiTrasmittente) 
			&& $xmldata->ContattiTrasmittente instanceof SimpleXMLElement
		){
			
			if($xmldata->ContattiTrasmittente->count() == 1){
				
				$this->__ContattiTrasmittente = $this->ContattiTrasmittente
					->loopXml($xmldata->ContattiTrasmittente);
			} else{
				
				$this->err()->setErrors(_('Contatti Trasmittente: Il nodo deve essere presente una sola volta in '.$classname));
			}
		}

		// PEC Destinatario
		if(isset($xmldata->PECDestinatario) 
			&& $xmldata->PECDestinatario instanceof SimpleXMLElement
			&& (string) $xmldata->PECDestinatario != ''
		){
			
			$this->__set('PECDestinatario', (string) $xmldata->PECDestinatario);
		}
		
		return $this;
	}
}
