<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'garbage_function.php';
require_once MODEL_PATH . 'garbage_get.php';
require_once MODEL_PATH . 'worker_function.php';
require_once MODEL_PATH . 'worker_get.php';

session_start();

if(is_worker_logged_in() === false){
  redirect_to(WORKER_LOGIN_URL);
}

if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

$token = get_csrf_token();

// 検索された氏名を取得
$username = get_post('username');

// 氏名が入力されていない場合、不正な形式の場合、ごみ管理画面にリダイレクト
if ($username === '' || is_valid_search_username($username) === false) {
  redirect_to(WORKER_GARBAGES_URL);
}

$db = get_db_connect();

// ログイン中の作業員を取得
$worker = get_login_worker($db);

// 表示するごみを取得
$garbages = get_garbages_by_username($db, $username);

//ごみの数を計算
$garbages_amount = count($garbages);

// ごみの情報（種類、ステータス、区）の番号を名前に変換。さらにステータスによって背景色を指定
$garbages = garbages_information_numbers_to_name($garbages);
include_once '../../../view/worker/select_user_view.php';