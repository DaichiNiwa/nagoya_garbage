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

$db = get_db_connect();

// ログイン中の作業員を取得
$worker = get_login_worker($db);

// トークンの発行
$token = get_csrf_token();

// その作業員の担当地域のごみ数を取得
$assigned_garbages_amount = get_assigned_garbages_amount($db, $worker['area']);

// 総ページ数を算出
$total_pages_number = calculate_total_pages_number($assigned_garbages_amount);

// ステータスやコメントを変更してから戻ってきた場合、セッションに前にいたページ番号が保存してあるので取得
if(get_session('current_page') !== ''){
  $current_page = (int)get_session('current_page');
  set_session('current_page', '');
} else {
  // ゲットで現在のページ番号を取得する場合や、新しくページを訪れた場合はこちらで取得
  $current_page = get_current_page($total_pages_number);
}

// 「xx件中 xx - xx件のごみ」の表示のためのテキストを生成
$garbages_count_text = make_items_count_text($assigned_garbages_amount, $current_page, 'ごみ');

// その作業員の担当地域のごみを10つ取得
$garbages = get_assigned_garbages($db, $current_page, $worker['area']);

// ごみの情報（種類、ステータス、区）の番号を名前に変換。さらにステータスによって背景色を指定
$garbages = garbages_information_numbers_to_name($garbages);
include_once '../../../view/worker/garbages_assigned_view.php';
