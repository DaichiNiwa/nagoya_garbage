<?php
require_once '../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'garbage_function.php';
require_once MODEL_PATH . 'garbage_insert.php';

session_start();

// トークンのチェック
if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

// トークンのリセット
get_csrf_token();

$type = get_post('type');
$comment = get_post('comment');
$username = get_post('username');
$phone_number = get_post('phone_number');
$email = get_post('email');
$area = get_post('area');
$address = get_post('address');

// データベース接続
$db = get_db_connect();

// garbagesテーブルに保存
if(regist_garbage($db, $collect_day->format('Y-m-d'), $type, $comment, $username, $phone_number, $email, $area, $address)){
  set_message('申し込みが完了しました。');
}else {
  set_error('登録に失敗しました。最初の画面に戻ってください。');
}

// ごみの種類と区を番号から名前に変換
$garbage_name = garbage_number_to_name($type);
$area_name = area_number_to_name($area);

include_once '../../view/register/finish_view.php';



