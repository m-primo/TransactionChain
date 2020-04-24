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
    public static function save():bool {
        if(self::isValid()) {
            global $transactions;
            file_put_contents(TRANSACTIONS_DB_FILE, json_encode($transactions, JSON_PRETTY_PRINT));
            return true;
        }
        return false;
    }
    public static function show(?bool $current = false):void {
        global $transactions;
        if($current) print json_encode($transactions, JSON_PRETTY_PRINT);
        else json_decode(file_get_contents(TRANSACTIONS_DB_FILE));
    }
    public static function isValid():bool {
        global $transactions;
        foreach($transactions as $tx) {
            if(!PoW::verifyHash($tx['prev'].':'.$tx['amount'].':'.$tx['date'].':'.$tx['account'], $tx['hash'])) return false;
        }
        return true;
    }
}
?>