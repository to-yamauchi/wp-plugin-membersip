<?php

class MembersipLine {

    function __construct() {}

    /**
     * ライン送信
     */
    static public function sendLine(array $to ,string $body) {
        
        // トークンを記載します
        $token = 'umoULHKXjTqLB93LoM1dNP3XomWXE80xtlowDJgGox54CjyVWqNHGgYM7ZA1CyhdcJ/rbVPTEGPCGAuSfddm6EcIpzhIhzQV1xJi7d73H7uyD6eXQA+onBAi1H8piJMWttCDujPEj7UK2Db/DZ6yJwdB04t89/1O/w1cDnyilFU=';

        $line['to'] = $to;
        $line['messages'] = array(
            array(
                "type" => "text",
                "text" => $body
            )
        );

        // リクエストヘッダを作成します
        $header = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
        ];
        $curl = curl_init('https://api.line.me/v2/bot/message/multicast');
        $options = [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_POST            => true,
            CURLOPT_HTTPHEADER      => $header,
            CURLOPT_POSTFIELDS      => json_encode($line)
        ];
        curl_setopt_array($curl, $options);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        $out = curl_exec($curl);
        curl_close($curl);
    }

        /**
     * ライン送信
     */
    static public function getLineId(array $to ,string $body) {
        
        // トークンを記載します
        $token = 'umoULHKXjTqLB93LoM1dNP3XomWXE80xtlowDJgGox54CjyVWqNHGgYM7ZA1CyhdcJ/rbVPTEGPCGAuSfddm6EcIpzhIhzQV1xJi7d73H7uyD6eXQA+onBAi1H8piJMWttCDujPEj7UK2Db/DZ6yJwdB04t89/1O/w1cDnyilFU=';

        $line['to'] = $to;
        $line['messages'] = array(
            array(
                "type" => "text",
                "text" => $body
            )
        );

        // リクエストヘッダを作成します
        $header = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
        ];
        $curl = curl_init('https://api.line.me/v2/bot/message/multicast');
        $options = [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_POST            => true,
            CURLOPT_HTTPHEADER      => $header,
            CURLOPT_POSTFIELDS      => json_encode($line)
        ];
        curl_setopt_array($curl, $options);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        $out = curl_exec($curl);
        curl_close($curl);
    }
}