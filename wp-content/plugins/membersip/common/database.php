<?php

class Database {

    public $result = 0;
    public $error_result = "";

    function __construct() {
    }

    public function setResult($res) {
        $this->result = $res;
    }

    public function getResult() {
        return $this->result;
    }

    /**
     * データ取得処理
     */
    public function select($sql_base, $values = array()){

        global $wpdb;

        try {

            if (count($values) == 0) {
                $sql = $sql_base;
            } else {
                $sql = $wpdb->prepare($sql_base, $values);
            }

            if ($sql == "") {
                throw new Exception("クエリーが正常に実施できません。prepareの指定を見直してください。");
            }

            // クエリー実行
            $this->setResult($wpdb->get_results($sql));

            // 実行エラー判定
            if ($wpdb->last_error != "") {
                throw new Exception($wpdb->last_error);
            }
            
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * データ取得処理
     */
    public function getSelect($sql){

        global $wpdb;

        try {

            // クエリー実行
            $this->setResult($wpdb->get_results($sql));

            // 実行エラー判定
            if ($wpdb->last_error != "") {
                throw new Exception($wpdb->last_error);
            }
            
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * 更新処理
     */
    public function update($sql, $values = array()){

        global $wpdb;

        try {
            $sql = $wpdb->prepare($sql, $values);

            if ($sql == "") {
                throw new Exception("クエリーが正常に実施できません。prepareの指定を見直してください。");
            }

            // クエリー実行
            $this->setResult($wpdb->query($sql));

            // 実行結果がfalse, 0の場合もエラーとする
            if ($wpdb->last_error != "") {
                throw new Exception($wpdb->last_error);
            }
            
        } catch (Exception $e) {
            $wpdb->rollback();
            throw new Exception($e);
        }
    }

    /**
     * 登録処理
     */
    public function insert($sql, $values = array()){

        global $wpdb;

        try {
            $sql = $wpdb->prepare($sql, $values);

            if ($sql == "") {
                throw new Exception("クエリーが正常に実施できません。prepareの指定を見直してください。");
            }

            // クエリー実行
            $ret = $wpdb->query($sql);
            $this->setResult($ret);

            // 実行結果がfalse, 0の場合もエラーとする
            if (false === $this->getResult() || 0 === $this->getResult()) {
                throw new Exception("クエリー実行でエラーが発生しました。 $wpdb->last_error");
            }

            return $wpdb->insert_id;
            
        } catch (Exception $e) {
            $wpdb->rollback();
            throw new Exception($e);
        }
    }

    public function create($sql, $values = array()) {

        global $wpdb;

        try {
            $sql = $wpdb->prepare($sql, $values);

            if ($sql == "") {
                throw new Exception("クエリーが正常に実施できません。prepareの指定を見直してください。");
            }

            // クエリー実行
            $ret = $wpdb->query($sql);
            $this->setResult($ret);

            // 実行結果がfalse, 0の場合もエラーとする
            if (false === $this->getResult() || 0 === $this->getResult()) {
                throw new Exception("クエリー実行でエラーが発生しました。 $wpdb->last_error");
            }

            return $wpdb->insert_id;
            
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }


    function begin(){
        global $wpdb;

        // トランザクションを開始
        $wpdb->query("START TRANSACTION");
    }

    function commit(){

        global $wpdb;

        // コミット
        $wpdb->query("COMMIT");
    }

    function rollback(){

        global $wpdb;

        // ロールバック
        $wpdb->query("ROLLBACK");
    }

}