<?php
require_once '../../../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'garbage_function.php';
require_once MODEL_PATH . 'garbage_get.php';
require_once MODEL_PATH . 'admin.php';

session_start();

if(is_admin_logged_in() === false){
  redirect_to(ADMIN_LOGIN_URL);
}

if(!is_valid_csrf_token($_POST['csrf_token'])){
  die('不正なアクセスが行われました。');
}

$token = get_csrf_token();

$status = get_post('status');
$area = get_post('area');

// 検索条件が一つも入力されていない場合、管理画面にリダイレクト
if ($status === '' && $area === '') {
  redirect_to(ADMIN_GARBAGES_URL);
}

$db = get_db_connect();

// 検索条件に合わせて表示するごみを取得
$garbages = get_searched_garbages($db, $status, $area);

// 取得に失敗した場合リダイレクト
if($garbages === false){
  redirect_to(ADMIN_GARBAGES_URL);
}

//ごみの数を計算
$garbages_amount = count($garbages);

// ごみの情報（種類、ステータス、区）の番号を名前に変換。さらにステータスによって背景色を指定
$garbages = garbages_information_numbers_to_name($garbages);
include_once '../../../view/admin/search_view.php';