<?php
require_once '../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'garbage_function.php';

session_start();

// 確認画面から戻ってきた場合、値を再表示する。
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // トークンのチェック
  if(!is_valid_csrf_token($_POST['csrf_token'])){
    die('不正なアクセスが行われました。');
  }
  
  $type = get_post('type');
  $comment = get_post('comment');
  $username = get_post('username');
  $phone_number = get_post('phone_number');
  $email = get_post('email');
  $area = get_post('area');
  $address = get_post('address');
  
  // 入力値のバリデーションをして、エラーメッセージを表示する
  validate_garbage($type, $comment, $username, $phone_number, $email, $area, $address);
}

// トークンの発行
$token = get_csrf_token();

include_once '../../view/register/register_view.php';
