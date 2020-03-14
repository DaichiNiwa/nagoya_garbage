<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'garbage_function.php';
require_once MODEL_PATH . 'garbage_get.php';
require_once MODEL_PATH . 'worker_function.php';
require_once MODEL_PATH . 'worker_get.php';

session_start();

// 作業員としてログインしていなければ作業員ログイン画面へ
if(is_worker_logged_in() === false){
  redirect_to(WORKER_LOGIN_URL);
}

$db = get_db_connect();

// ログイン中の作業員を取得
$worker = get_login_worker($db);

// トークンの発行
$token = get_csrf_token();

// 総ごみ数を取得
$all_garbages_amount = get_all_garbages_amount($db);

// 総ページ数を算出
$total_pages_number = calculate_total_pages_number($all_garbages_amount);

// ゲットで現在のページ番号を取得
$current_page = get_current_page($total_pages_number);

// 「xx件中 xx - xx件のごみ」の表示のためのテキストを生成
$garbages_count_text = make_items_count_text($all_garbages_amount, $current_page, 'ごみ');

// 表示するごみを10つ取得
$garbages = get_garbages($db, $current_page);

// ごみの情報（種類、ステータス、区）の番号を名前に変換。さらにステータスによって背景色を指定
$garbages = garbages_information_numbers_to_name($garbages);
include_once '../../../view/worker/garbages_view.php';
