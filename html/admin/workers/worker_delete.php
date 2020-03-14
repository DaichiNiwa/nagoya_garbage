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

// IDが1の作業員はサンプルユーザーとして削除できない設定に
if($worker_id === '1'){
  set_error('現在、この作業員は削除できない設定になっています。');
  redirect_to(ADMIN_WORKERS_URL);
}

$db = get_db_connect();

if(delete_worker($db, $worker_id)){
  set_message('作業員を削除しました。');
} else {
  set_error('作業員の削除に失敗しました。');
}

redirect_to(ADMIN_WORKERS_URL);