<?php

class MembersipValidation {

    function __construct() {}

    static public function common($valid, $validData) {

        try {

            // バリデーション情報（XML）をパース
            $valids = new SimpleXMLElement($validData[0]->value);

            $ERROR = array();

            // バリデーション開始
            $error_no = 0;
            foreach ($valid as $post_key => $post_val) {

                // タイプ項目については、バリデーションを行わない
                if ($post_key == "type") {
                    continue;
                }

                // バリデーションリスト
                foreach ($valids as $key => $item) {
                    foreach ($item->validations as $key => $validations) {

                        // チェック対象のキー（inputのname）が一致したら、チェックを行う
                        if ($item->target == $post_key) {

                            foreach ($validations as $key => $validations_val) {

                                // 空文字チェック
                                if (!empty((string)$validations_val->empty)) {

                                    if (empty($post_val)) {

                                        // バリデーションに引っかかった場合は、エラー内容を登録して次の項目へ
                                        $ERROR[$error_no++] = "入力内容「".$post_val."」-> エラー内容：".(string)$validations_val->message;
                                        break;
                                    }
                                    continue;
                                }

                                // 正規表現チェック
                                if (!empty((string)$validations_val->match)) {

                                    if (!preg_match($validations_val->match, $post_val)) {

                                        // バリデーションに引っかかった場合は、エラー内容を登録して次の項目へ
                                        $ERROR[$error_no++] = "入力内容「".$post_val."」-> エラー内容：".(string)$validations_val->message;
                                        break;
                                    }
                                    continue;
                                }
                            }
                        }

                        // 対象のキーがなければ、次の項目へ
                        break;
                    }
                }
            }

            return $ERROR;

        } catch(Exception $e) {

            MembersipLogger::errorLog($e);
        }
    }

    /**
     * ユーザー編集　入力チェック
     * @return ture: エラー有り、false: エラー無し
     */
    static public function isError($valid) {

        global $membersip_sql_path;

        try {

            if ($valid == null) {
                return true;
            }

            if (is_object($valid) == false) {
                return true;
            }

            // バリデーション情報を取得
            $getValidData = file_get_contents($membersip_sql_path.'getUserRegistValidation.sql');
            $Database = new Database();
            $Database->select($getValidData);
            $validData = $Database->getResult();

            $ERROR = array();
            $ERROR = self::common($valid, $validData);

            if (count($ERROR) > 0){

                // エラー内容をセッションに登録
                MembersipError::setErrors($ERROR);
                return true;
            }

            return false;

        } catch(Exception $e) {

            MembersipLogger::errorLog($e);
        }
    }
}