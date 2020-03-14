<?php
require_once '../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'admin.php';

session_start();

// 管理者としてログインしていなければログイン画面へ
if(is_admin_logged_in() === false){
  redirect_to(ADMIN_LOGIN_URL);
}

// 管理者のIDを変更できない設定になっているかどうか
if(AUTH_ADMIN_CHANGE === false){
  set_error('ログインIDを変更できない設定になっています。');
  redirect_to(ADMIN_ADMIN_URL);
}

$db = get_db_connect();

$login_id = get_post('login_id');

if(change_admin_login_id($db, $login_id)){
  set_message('ログインIDを変更しました。');
} else {
  set_error('ログインIDの変更に失敗しました。');
}

redirect_to(ADMIN_ADMIN_URL);
