<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/29/2016
 * Time: 10:36
 */
ini_set('default_socket_timeout', '1000');
ini_set('upload_max_filesize',  '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_execution_time', '1000');
ini_set('max_input_time', '1000');
ini_set('memory_limit', '1024M');

sleep(40);
$sTest = serialize($_GET);
echo 'test'.$sTest;
