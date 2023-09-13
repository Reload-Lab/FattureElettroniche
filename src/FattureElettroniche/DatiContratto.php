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
use \ArrayAccess;
use \Iterator;
use \Countable;

class DatiContratto extends DatiOrdineAcquisto implements ArrayAccess, Iterator, Countable {

}
