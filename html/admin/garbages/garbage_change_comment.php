<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'garbage_function.php';
require_once MODEL_PATH . 'garbage_insert.php';
require_once MODEL_PATH . 'admin.php';

session_start();

if(is_admin_logged_in() === false){
  redirect_to(ADMIN_LOGIN_URL);
}

if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

$db = get_db_connect();

$garbage_id = get_post('garbage_id');
$comment = get_post('comment');

if(change_garbage_admin_comment($db, $garbage_id, $comment)){
  set_message('管理者コメントを変更しました。');
} else {
  set_error('管理者コメントの変更に失敗しました。');
}

redirect_to(ADMIN_GARBAGES_URL);