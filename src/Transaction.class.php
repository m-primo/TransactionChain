<?php
class Transaction {
    public $prev = null;
    public $amount = null;
    public $date = null;
    public $account = null;
    private $toHash = null;
    public $hash = null;
    public function __construct($prev, ?float $amount, ?string $account = null, $date = null, ?bool $isFake = false) {
        if(is_array($prev)) $this->prev = $prev ? $prev['hash'] : null;
        if(is_object($prev)) $this->prev = $prev ? $prev->hash : null;
        $this->amount = $amount ? round($amount, ROUND_PREC) : 0;
        $this->date = $date ? $date : @date(DATE_FORMAT);
        $this->account = $account ? $account : null;
        $this->toHash = $this->prev.':'.$this->amount.':'.$this->date.':'.$this->account;
        $this->hash = PoW::hash($this->toHash);
        if(!$isFake) if($this->isValid()) $this->save();
    }
    public function isValid():bool {
        return PoW::verifyHash($this->toHash, $this->hash);
    }
    public function save():void {
        global $transactions;
        $transactions[] = $this->asArray();
    }
    public function asArray():array {
        return array(
            'prev' => $this->prev,
            'date' => $this->date,
            'amount' => $this->amount,
            'account' => $this->account,
            'hash' => $this->hash,
        );
    }
}
?>