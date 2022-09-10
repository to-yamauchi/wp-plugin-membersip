<?php

class MembersipMail {

    function __construct() {}

    /**
     * メール送信
     */
    static public function sendMail(string $from ,array $to ,string $subject ,string $body) {

        // トークンを記載します
        $token = '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';

        // リクエストヘッダを作成します
        $mail['personalizations'] = array(
            array(
                "to" => $to,
                "subject" => $subject
            ),
        );
        $mail['from']['email'] = $from;
        $mail['content'] = array(
            array(
                "type" => "text/plain",
                "value" => $body
            )
        );

        $header = [
                'Content-Type: application/json',
                'Authorization: Bearer '.$token
        ];
        $curl = curl_init('https://api.sendgrid.com/v3/mail/send');
        $options = [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_POST            => true,
            CURLOPT_HTTPHEADER      => $header,
            CURLOPT_POSTFIELDS      => json_encode($mail)
        ];
        curl_setopt_array($curl, $options);

        curl_setopt($curl,CURLINFO_HEADER_OUT,true);
        $out = curl_exec($curl);
        if ($out != "") {
            throw new Error($out);
        }
        curl_close($curl);
    }
}