<?php
require_once '../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'admin.php';

session_start();

// 管理者としてすでにログイン状態なら、ごみ一覧画面へリダイレクト
if(is_admin_logged_in() === true){
  redirect_to(ADMIN_GARBAGES_URL);
}

if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

$token = get_csrf_token();

$login_id = get_post('login_id');
$password = get_post('password');

$db = get_db_connect();

if(admin_login($db, $login_id, $password) === false){
  set_error('ログインに失敗しました。');
  redirect_to(ADMIN_LOGIN_URL);
}

redirect_to(ADMIN_GARBAGES_URL);