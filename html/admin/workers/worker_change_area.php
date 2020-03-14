<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'admin.php';
require_once MODEL_PATH . 'worker_insert.php';

session_start();

if(is_admin_logged_in() === false){
  redirect_to(ADMIN_LOGIN_URL);
}

if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

get_csrf_token();

$worker_id = get_post('worker_id');
$area = get_post('area');

$db = get_db_connect();

// workersテーブルに保存
if(update_worker_area($db, $worker_id, $area)){
  set_message('担当区を変更しました。');
}else {
  set_error('担当区の変更に失敗しました。');
}

redirect_to(ADMIN_WORKERS_URL);