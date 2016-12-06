<?php
/**
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright (c) Digiflex Development Team 2010
 * @version 1.0 
 * @author Johnny Mast <mastjohnny@gmail.com>
 * @author Paul Dragoonis <dragoonis@php.net>
 * @since Version 1.0
 */
error_reporting(E_ALL);
ini_set('display_errors', true);

require 'ID3/ID3.php';

$file = new ID3(dirname(__FILE__).'/youGotmail.mp3');
$info = $file->fileinfo();


print_r($info['fileinfo']['TAGS']);
return;
exit;
$info = $info['fileinfo']['TAGS']['APIC'];

header('Content-type: '.$info['MIME']);
echo $info['DATA'];
?>