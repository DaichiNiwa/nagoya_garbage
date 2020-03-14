<?php
require_once '../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'worker_function.php';
require_once MODEL_PATH . 'worker_get.php';

session_start();
if(is_worker_logged_in() === true){
  redirect_to(WORKER_ASSIGNED_URL);
}

if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

$token = get_csrf_token();

$login_id = get_post('login_id');
$password = get_post('password');

$db = get_db_connect();

if(worker_login($db, $login_id, $password) === false){
  set_error('ログインに失敗しました。');
  redirect_to(WORKER_LOGIN_URL);
}

redirect_to(WORKER_ASSIGNED_URL);