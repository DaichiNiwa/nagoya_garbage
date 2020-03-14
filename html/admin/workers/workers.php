<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'admin.php';
require_once MODEL_PATH . 'worker_function.php';
require_once MODEL_PATH . 'worker_get.php';

session_start();

// 管理者としてログインしていなければログイン画面へ
if(is_admin_logged_in() === false){
  redirect_to(ADMIN_LOGIN_URL);
}

// トークンの発行
$token = get_csrf_token();

$db = get_db_connect();

// 総作業員数を取得
$all_workers_amount = get_all_workers_amount($db);

// 総ページ数を算出
$total_pages_number = calculate_total_pages_number($all_workers_amount);

// ゲットで現在のページ番号を取得
$current_page = get_current_page($total_pages_number);

// 「xx件中 xx - xx件の作業員」の表示のためのテキストを生成
$workers_count_text = make_items_count_text($all_workers_amount, $current_page, '作業員');

// 表示する作業員を10つ取得
$workers = get_workers($db, $current_page);

include_once '../../../view/admin/workers_view.php';
