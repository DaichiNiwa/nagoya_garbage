<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'admin.php';
require_once MODEL_PATH . 'worker_function.php';
require_once MODEL_PATH . 'worker_insert.php';
require_once MODEL_PATH . 'worker_get.php';

session_start();

if(is_admin_logged_in() === false){
  redirect_to(ADMIN_LOGIN_URL);
}

// トークンのチェック
if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

// トークンのリセット
get_csrf_token();

$login_id = get_post('login_id');
$password = get_post('password');
$confirm_password = get_post('confirm_password');
$worker_name = get_post('worker_name');
$area = get_post('area');
$comment = get_post('comment');

// データベース接続
$db = get_db_connect();

// workersテーブルに保存
if(regist_worker($db, $login_id, $password, $confirm_password, $worker_name, $area, $comment)){
  set_message('登録が完了しました。');
}else {
  set_error('登録に失敗しました。');
}

redirect_to(NEW_WORKER_URL);