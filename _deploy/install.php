<?php
die('OFF');
$file = 'budgeteer.tar.bz2';

if ( !function_exists('function_exists') )
    die('Funktion "shell_exec()" nicht verfügbar.');

if ( file_exists(dirname(__FILE__) . '/' . $file) ) {
    shell_exec('tar xjf ' . dirname(__FILE__) . '/' . $file);
    unlink(dirname(__FILE__) . '/' . $file);
    unlink(__FILE__);
    header("Location: /admin/install");
}

?>
