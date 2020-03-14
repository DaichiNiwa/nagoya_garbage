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

$db = get_db_connect();

if(delete_garbages($db)){
  set_message('ごみを削除しました。');
} else {
  set_error('ごみの削除に失敗しました。');
}

redirect_to(ADMIN_GARBAGES_URL);