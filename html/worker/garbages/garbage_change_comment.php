<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'garbage_function.php';
require_once MODEL_PATH . 'garbage_insert.php';
require_once MODEL_PATH . 'worker_function.php';
require_once MODEL_PATH . 'worker_get.php';

session_start();

if(is_worker_logged_in() === false){
  redirect_to(WORKER_LOGIN_URL);
}

if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

$db = get_db_connect();

$worker = get_login_worker($db);

$garbage_id = get_post('garbage_id');
$comment = get_post('comment');
$current_page = get_post('current_page');

// セッションに現在のページ番号を保存し、コメントを変更した後に同じページに戻れるようにする。
set_session('current_page', $current_page);

if(change_garbage_worker_comment($db, $garbage_id, $comment, $worker['worker_id'])){
  set_message('作業員コメントを変更しました。');
} else {
  set_error('作業員コメントの変更に失敗しました。');
}

redirect_to(WORKER_ASSIGNED_URL);