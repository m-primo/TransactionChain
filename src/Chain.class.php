<?php
class Chain {
    public static function balanceOf(string $account):float {
        global $transactions;
        $balance = 0;
        foreach($transactions as $trans) {
            if($trans['account'] == $account) $balance += round($trans['amount'], ROUND_PREC);
        }
        return round($balance, ROUND_PREC);
    }
    public static function save():void {
        if(self::isValid()) {
            global $transactions;
            file_put_contents(TRANSACTIONS_DB_FILE, json_encode($transactions, JSON_PRETTY_PRINT));
        }
    }
    public static function show(?bool $current = false):void {
        global $transactions;
        if($current) print json_encode($transactions, JSON_PRETTY_PRINT);
        else json_decode(file_get_contents(TRANSACTIONS_DB_FILE));
    }
    public static function isValid():bool {
        global $transactions;
        $txo = [];
        $i = 0;
        foreach($transactions as $tx) {
            $txo[] = new Transaction($txo[count($txo)-1], $tx['amount'], $tx['account'], $tx['date'], true);
            if(!$txo[$i]->isValid()) return false;
            if(!PoW::verifyHash($txo[$i]->prev.':'.$txo[$i]->amount.':'.$txo[$i]->date.':'.$txo[$i]->account, $txo[$i]->hash)) return false;
            $i++;
        }
        return true;
    }
}
?>
