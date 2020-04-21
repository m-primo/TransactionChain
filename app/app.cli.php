<?php
function stdin() {
    return trim(fgets(STDIN));
}
//-------------------------------
function main() {
    global $transactions;
    echo "Enter a command [add(a), balance(b), show(s), quit(q)]: ";
    $cmd = stdin();
    if($cmd == 'add' || $cmd == 'a') {
        echo "Amount: ";
        $amount = round(stdin(), ROUND_PREC);
        echo "Account: ";
        $account = stdin();
        $prev_tx = $transactions[count($transactions)-1];
        new Transaction($prev_tx, $amount, $account);
    } elseif($cmd == 'balance' || $cmd == 'b') {
        echo "Account: ";
        $account = stdin();
        echo Chain::balanceOf($account).eol."------------------------------------".eol;
    } elseif($cmd == 'quit' || $cmd == 'q') {
        exit;
    }
    if($cmd == 'show' || $cmd == 's' || $cmd == 'add' || $cmd == 'a') {
        echo "------------------------------------".eol;
        Chain::show(true);
        echo eol.eol;
        if(isset($account)) echo "\t".Chain::balanceOf($account).eol;
        Chain::save();
        echo "------------------------------------".eol;
    }
}
while(true) main();
?>