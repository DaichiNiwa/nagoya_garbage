<?php
require_once '../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'admin.php';

session_start();

if(is_admin_logged_in() === false){
  redirect_to(ADMIN_LOGIN_URL);
}

// 管理者のパスワードを変更できない設定になっているかどうか
if(AUTH_ADMIN_CHANGE === false){
  set_error('パスワードを変更できない設定になっています。');
  redirect_to(ADMIN_ADMIN_URL);
}

$current_password = get_post('current_password');
$new_password = get_post('new_password');
$confirm_new_password = get_post('confirm_new_password');

$db = get_db_connect();

if(change_admin_password($db, $current_password, $new_password, $confirm_new_password)){
  set_message('パスワードを変更しました。');
} else {
  set_error('パスワードの変更に失敗しました。');
}

redirect_to(ADMIN_ADMIN_URL);
