<?php
define('fds', '../../');
require_once fds.'inc.php';
// ---------------------
function addTransaction(string $account, float $amount) {
    global $transactions;
    $prev_tx = $transactions[count($transactions)-1];
    new Transaction($prev_tx, $amount, $account);
    Chain::save();
    return 200;
}
function getBalance(string $account) {
    return Chain::balanceOf($account);
}
function getChain() {
    Chain::show(true);
}
// ---------------------
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && isset($_POST['account']) && isset($_POST['amount'])) {
    $account = $_POST['account'];
    $amount = round($_POST['amount'], ROUND_PREC);
    die(json_encode([
        addTransaction($account, $amount),
        $account,
        $amount,
        getBalance($account)
    ]));
}
if($_GET['get_transactionchain'] == "1") {
    getChain();
    exit;
}
?>