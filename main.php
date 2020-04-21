<?php
//error_reporting(0);
declare(strict_types=1);
define('eol', PHP_EOL);
define('DS', DIRECTORY_SEPARATOR);
define('DIR_SRC', 'src'.DS);
define('DIR_APP', 'app'.DS);
define('DIR_DB', 'db'.DS);
define("DATE_FORMAT", "M d, Y H:i:s");
define('TRANSACTIONS_DB_FILE', DIR_DB.'chain.db.json');
define('ROUND_PREC', 2);
define('APP_TYPE', 'cli');
// ---------------------------
spl_autoload_register(function($name) {
    $fName = DIR_SRC.$name.'.class.php';
    if(file_exists($fName)) require_once $fName;
});
//-------------------------
$transactions = [];
if(!file_exists(TRANSACTIONS_DB_FILE)) {
    new Transaction(null, null, "Genesis Transaction");
    Chain::save();
}
$transactions = json_decode(file_get_contents(TRANSACTIONS_DB_FILE), true);
// ---------------------
$app_types = ['cli'];
// ---------------------
if(in_array(APP_TYPE, $app_types)) require_once DIR_APP.'app.'.strtolower(APP_TYPE).'.php';
?>