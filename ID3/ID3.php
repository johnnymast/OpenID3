<?php
/**
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright (c) Digiflex Development Team 2010
 * @version 1.0 
 * @author Johnny Mast <mastjohnny@gmail.com>
 * @author Paul Dragoonis <dragoonis@php.net>
 * @since Version 1.0
 */

define('ROOT', dirname(__FILE__) . '/');
define('CLASSPATH', ROOT . 'classes/');
define('INTERFACEPATH', ROOT . 'interfaces/');

define('HEADER_SIZE', '10');
	
include_once(CLASSPATH . 'class.ID3v1.php');
include_once(CLASSPATH . 'class.ID3v2.php');

require_once(CLASSPATH . 'class.ID3Data.php');
require_once(CLASSPATH . 'class.ID3.php');

