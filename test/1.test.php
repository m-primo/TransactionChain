<?php
define('fds', '../');
require_once fds.'inc.php';
// ---------------------
var_dump(Chain::isValid()); // current chain validate
var_dump(Chain::save()); // try to save the chain, current
$transactions[1]['amount'] = 500; // change a transaction
var_dump(Chain::save()); // try to save the chain, after changing a transaction
var_dump(Chain::isValid()); // chain validate after changing a transaction
?>