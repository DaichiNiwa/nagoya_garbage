<?php
require_once '../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'garbage.php';

session_start();

// トークンのチェック
if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

$token = get_csrf_token();

$type = get_post('type');
$comment = get_post('comment');
$username = get_post('username');
$phone_number = get_post('phone_number');
$email = get_post('email');
$area = get_post('area');
$address = get_post('address');

// 入力値のバリデーション
$is_valid_information = validate_garbage($type, $comment, $username, $phone_number, $email, $area, $address);

// ごみの種類と区を番号から名前に変換
$garbage_name = garbage_number_to_name($type);
$area_name = area_number_to_name($area);

include_once '../../view/register/confirm_view.php';



