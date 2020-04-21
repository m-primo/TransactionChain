<?php
class PoW {
    public static function hash(string $data):string {
        return hash('sha256', $data);
    }
    public static function verifyHash(string $data, string $data_hash):bool {
        return hash_equals(self::hash($data), $data_hash);
    }
}
?>