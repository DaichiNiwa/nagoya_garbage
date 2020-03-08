<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'garbage_function.php';
require_once MODEL_PATH . 'garbage_insert.php';

session_start();

$db = get_db_connect();

if(delete_garbages($db)){
  set_message('ごみを削除しました。');
} else {
  set_error('ごみ削除に失敗しました。');
}

redirect_to(ADMIN_GARBAGES_URL);