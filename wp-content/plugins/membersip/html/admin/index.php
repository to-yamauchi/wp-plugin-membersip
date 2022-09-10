<?php

//=================================================
// 管理画面に「メニュー」を追加登録する
//=================================================
add_action('admin_menu', function(){
    
    // 認証設定画面メニュー追加	
    add_menu_page(
        'Membersip' 		                  // ページのタイトルタグ<title>に表示されるテキスト
        , 'Membersip'                         // 左メニューとして表示されるテキスト
        , 'administrator'       	          // 必要な権限 manage_options は通常 administrator のみに与えられた権限
        , 'membersip_page'                    // 左メニューのスラッグ名 →URLのパラメータに使われる /wp-admin/admin.php?page=message_page
        , 'MembersipPluginPortal::showPage'   // メニューページを表示する際に実行される関数(サブメニュー①の処理をする時はこの値は空にする)
        , 'dashicons-admin-users'             // メニューのアイコンを指定 https://developer.wordpress.org/resource/dashicons/#awards
        , 99                                  // メニューが表示される位置のインデックス(0が先頭)
    );

    // ユーザー管理画面メニュー追加(初期化ページ)
    add_submenu_page( 
        'membersip_page', 
        '認証設定管理', 
        '認証設定管理', 
        'administrator', 
        'init_page', 
        'MembersipPluginAdmin::showPage'
    );

    //ユーザー管理画面メニュー追加
    add_submenu_page( 
        'membersip_page', 
        'ユーザー管理', 
        'ユーザー管理', 
        'administrator', 
        'user_admin_page', 
        'MembersipUserAdmin::showPage'
    );
});