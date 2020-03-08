<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'garbage_function.php';
require_once MODEL_PATH . 'garbage_insert.php';

session_start();

if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

$db = get_db_connect();

$garbage_id = get_post('garbage_id');

if(delete_garbage($db, $garbage_id) === true){
  set_message('ごみを削除しました。');
} else {
  set_error('ごみ削除に失敗しました。');
}

redirect_to(ADMIN_GARBAGES_URL);