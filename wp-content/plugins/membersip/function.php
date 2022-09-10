<?php

//=================================================
// 以下ユーザー用
//=================================================

/**
 * 現在のURLを取得
 */
function getCurrentURL(){
    return str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);
}

/**
 * ユーザー情報を取得
 */
function user() {

    global $post;

    if (MembersipUserAuth::isLogin() == true && $post->type != "logout"){ 
        return MembersipSession::getUser();
    }
    return null;
}


/**
 * ログインユーザー名を取得
 */
function username() {
    global $post;

    if (MembersipUserAuth::isLogin() == true && $post->type != "logout"){ 
        if (user() != null) {
            return user()->sei[0]->data." ".user()->mei[0]->data;
        }
    }
    return "";
}


/**
 * 編集用のユーザー情報を取得
 */
function edit() {

    global $post;

    $data = array();

    if (MembersipUserAuth::isLogin() == true && $post->type != "logout"){ 
       
        $edit = MembersipSession::getEdit();
        $data = $edit;
    } 
    return (object)$data;
}

/**
 * 登録用のユーザー情報を取得
 */
function regist() {

    return MembersipSession::getRegist();
}

//=================================================
// 以下管理用
//=================================================

/**
 * 管理ページ用ルートフォルダ
 */
function membersip_content() {
    return site_url()."/wp-content/plugins/membersip/html/";
}