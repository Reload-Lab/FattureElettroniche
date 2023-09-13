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
use \Exception;

class ErrorsHandler extends Exception {
	
	/**
	 * Array which holds sql error
	 * @var array
	 */
	protected $errors = array();
	
	public $imploder = '<br>';
	
	/**
	 * Singleton array ErrorsHandler object
	 * @var array
	 */
	private static $_instance;
	
	public function __construct($message = '', $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
	
	/**
	 * Singleton method
	 *
	 * @param string $key	Nome istanza ErrorsHandler
	 *
	 * @return ErrorsHandler object
	 */
    public static function get($key)
	{
		if(!isset(self::$_instance[$key])){
            
			$class = __CLASS__;
            self::$_instance[$key] = new $class;
        }
 
        return self::$_instance[$key];
    }

	/**
	 * Aggiunge un errore all'Array errors
	 *
	 * @param string $err
	 *
	 * @set errors
	 * 
	 * @return ErrorsHandler object
	 */
	public function setErrors($err)
	{
		if(is_string($err)){
			
			array_push($this->errors, $err);
		}
		
		return $this;
	}

	/**
	 * Restituisce gli errori dall'Array errors
	 * 
	 * @param int $key
	 *
	 * @return array
	 */
	public function getErrors($key = null)
	{
		if(is_numeric($key) && isset($this->err[$key])){
			
			return $this->errors[$key];
		} else{
			
			return count($this->errors) > 0? $this->errors: false;
		}
	}
	
	/**
	 * Metodo che restituisce l'ultimo errore come stringa
	 *
	 * @return string
	 */
	public function lastError()
	{
		$last = count($this->errors) - 1;
		return $last >= 0? $this->errors[$last]: '';
	}

	/**
	 * Verifica se ci sono stati errori
	 *
	 * @return bool
	 */
	public function hasErrors()
	{
		return count($this->errors) > 0? true: false;
	}

	/**
	 * Restituisce gli errori dall'Array errors come stringa
	 *
	 * @return string
	 */
	public function showErrors()
	{
		return count($this->errors) > 0? implode($this->imploder, $this->errors): '';
	}

	/**
	 * Pulisce array errori
	 *
	 * @return ErrorsHandler object
	 */
	public function clearErrors()
	{
		$this->errors = array();
		
		return $this;
	}
}
