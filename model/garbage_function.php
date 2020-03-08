<?php
require_once 'functions.php';
require_once 'db.php';

// 管理画面でのページ番号の取得
function get_current_page($total_pages_number){
  $current_page = (int)get_get('current_page', 1);
  if(is_valid_current_page($current_page, $total_pages_number) === false){
    $current_page = 1;
  }
  return $current_page;
}

// 管理画面でのページ番号のバリデーション
function is_valid_current_page($current_page, $total_pages_number)
{
  $is_valid = true;
  // $current_pageが0以下の数字、または$total_pages_numberより大きいならfalse
  if ($current_page <= 0 || $current_page > $total_pages_number) {
    set_error('存在しないページ番号が入力されています。');
    $is_valid = false;
  }
  return $is_valid;
}

// 「xx件中 xx - xx件のごみ」の表示のためのテキストを生成
function make_garbages_count_text($all_garbages_amount, $current_page){
  $list_start_number = DISPLAY_GARBAGES_NUMBER * ($current_page - 1) + 1;
  $list_end_number = $current_page * DISPLAY_GARBAGES_NUMBER;
  // ごみが1つもない場合
  if($all_garbages_amount === 0){
    return 'ごみがありません';
  }
  // 最終ページでごみが１つしかない場合
  if($all_garbages_amount === $list_start_number){
    return "{$all_garbages_amount}件中 {$all_garbages_amount}件目のごみ";
  }
  // 最終ページの場合
  if($all_garbages_amount < $list_end_number){
    return "{$all_garbages_amount}件中 {$list_start_number} - {$all_garbages_amount}件目のごみ";
  }
  // 通常のページ  
  return "{$all_garbages_amount}件中 {$list_start_number} - {$list_end_number}件目のごみ";
}

//管理画面でのページ数を算出
function calculate_total_pages_number($all_garbages_amount){
  return ceil($all_garbages_amount / DISPLAY_GARBAGES_NUMBER);
}

// ごみの入力値のバリデーション
function validate_garbage($type, $comment, $username, $phone_number, $email, $area, $address)
{
  $is_valid_garbage_type = is_valid_garbage_type($type);
  $is_valid_comment = is_valid_comment($comment);
  $is_valid_username = is_valid_username($username);
  $is_valid_phone_number = is_valid_phone_number($phone_number);
  $is_valid_email = is_valid_email($email);
  $is_valid_area = is_valid_area($area);
  $is_valid_address = is_valid_address($address);

  return $is_valid_garbage_type
    && $is_valid_comment
    && $is_valid_username
    && $is_valid_phone_number
    && $is_valid_email
    && $is_valid_area
    && $is_valid_address;
}

// 個別の入力値のバリデーション
function is_valid_garbage_status($status)
{
  $is_valid = true;
  if (is_valid_format($status, PERMITTED_GERBAGE_STATUS) === false) {
    set_error('不正なごみのステータスが入力されています。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_garbage_type($type)
{
  $is_valid = true;
  if (is_valid_format($type, PERMITTED_GERBAGE_TYPE) === false) {
    set_error('不正なごみの種類が入力されています。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_comment($comment)
{
  $is_valid = true;
  if (is_valid_length($comment, 0, COMMENT_LENGTH_MAX) === false) {
    set_error('コメントは' . COMMENT_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_username($username)
{
  $is_valid = true;
  if (is_valid_length($username, NAME_LENGTH_MIN, NAME_LENGTH_MAX) === false) {
    set_error('氏名は' . NAME_LENGTH_MIN . '文字以上、' . NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_phone_number($phone_number)
{
  $is_valid = true;
  if (is_valid_format($phone_number, PERMITTED_PHONE_NUMBER) === false) {
    set_error('電話番号は10または11桁の半角数字、ハイフンなしで入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_email($email)
{
  $is_valid = true;
  if (is_valid_format($email, PERMITTED_EMAIL) === false) {
    set_error('メールアドレスの形式が間違っています。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_area($area)
{
  $is_valid = true;
  if (is_valid_format($area, PERMITTED_AREA_TYPE) === false) {
    set_error('不正な区が入力されています。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_address($address)
{
  $is_valid = true;
  if (is_valid_length($address, ADDRESS_LENGTH_MIN, ADDRESS_LENGTH_MAX) === false) {
    set_error('以下の住所は' . ADDRESS_LENGTH_MIN . '文字以上、' . ADDRESS_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}

// 名前でごみを検索するときのバリデーション
function is_valid_search_username($username)
{
  $is_valid = true;
  if (is_valid_length($username, 1, NAME_LENGTH_MAX) === false) {
    set_error('検索する氏名は' . NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}

// ごみの情報（種類、ステータス、区）の番号を名前に変換
function garbages_information_numbers_to_name($garbages)
{
  foreach($garbages as $garbage){
    $garbage['type'] = garbage_number_to_name($garbage['type']);
    $garbage['area'] = area_number_to_name($garbage['area']);
    $garbage['bg_color'] = bg_color_by_status($garbage['status']);
    $changed_garbages[] = $garbage;
  }
  return $changed_garbages;
}

// ごみのステータスの番号を名前に変換
function status_number_to_name($status)
{
  switch ($status) {
    case '0':
      $garbage_status_name = '未回収';
      break;
    case '1':
      $garbage_status_name = '回収済';
      break;
    case '2':
      $garbage_status_name = '回収前保留';
      break;
    case '3':
      $garbage_status_name = '回収後保留';
      break;
    case '4':
      $garbage_status_name = '回収不可';
      break;
    case '':
      $garbage_status_name = '選択なし';
      break;
    default:
      $garbage_status_name = false;
      break;
  }
  return $garbage_status_name;
}

// ごみの種類の番号を名前に変換
function garbage_number_to_name($type)
{
  switch ($type) {
    case 0:
      $garbage_name = '大型家具';
      break;
    case 1:
      $garbage_name = '小型家具';
      break;
    case 2:
      $garbage_name = '大型家電';
      break;
    case 3:
      $garbage_name = '小型家電';
      break;
    case 4:
      $garbage_name = '布団マットレス類';
      break;
    case 5:
      $garbage_name = 'スポーツ用具';
      break;
    case 6:
      $garbage_name = 'その他';
      break;
    default:
      $garbage_name = false;
      break;
  }
  return $garbage_name;
}

// 区の番号を名前に変換
function area_number_to_name($area)
{
  switch ($area) {
    case '0':
      $area_name = '千種区';
      break;
    case '1':
      $area_name = '東区';
      break;
    case '2':
      $area_name = '北区';
      break;
    case '3':
      $area_name = '西区';
      break;
    case '4':
      $area_name = '中村区';
      break;
    case '5':
      $area_name = '中区';
      break;
    case '6':
      $area_name = '昭和区';
      break;
    case '7':
      $area_name = '瑞穂区';
      break;
    case '8':
      $area_name = '熱田区';
      break;
    case '9':
      $area_name = '中川区';
      break;
    case '10':
      $area_name = '港区';
      break;
    case '11':
      $area_name = '名東区';
      break;
    case '12':
      $area_name = '天白区';
      break;
    case '':
      $area_name = '選択なし';
      break;
    default:
      $area_name = false;
      break;
  }
  return $area_name;
}

// ごみのステータスによって背景色を指定
function bg_color_by_status($status)
{
  switch ($status) {
    case 0:
      $bg_color = '#dff0d8';
      break;
    case 1:
      $bg_color = '#d9edf7';
      break;
    case 2:
      $bg_color = '#fcf8e3';
      break;
    case 3:
      $bg_color = '#fcf8e3';
      break;
    case 4:
      $bg_color = '#f2dede';
      break;
    default:
      $bg_color = '';
      break;
  }
  return $bg_color;
}

// ごみにコメントが１つでもついているか確認
function has_comment($user_comment, $admin_comment, $worker_comment){
  $has_comment = false;
  if($user_comment !== '' && $user_comment !== null){
    return true;
  }
  if($admin_comment !== '' && $admin_comment !== null){
    return true;
  }
  if($worker_comment !== '' && $worker_comment !== null){
    return true;
  }
  
  return $has_comment;
}
