<?php
require_once 'functions.php';
require_once 'db.php';

// ごみにコメントが１つでもついているか確認（コメントが１つもない場合、ごみ管理画面でそのごみのコメント欄を表示しない）
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

// ごみ登録時の入力値のバリデーション
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

// 以下ごみに関する個別の入力値のバリデーション
// ごみのステータス
function is_valid_garbage_status($status)
{
  $is_valid = true;
  if (is_valid_format($status, PERMITTED_GERBAGE_STATUS) === false) {
    set_error('不正なごみのステータスが入力されています。');
    $is_valid = false;
  }
  return $is_valid;
}

// ごみの種類
function is_valid_garbage_type($type)
{
  $is_valid = true;
  if (is_valid_format($type, PERMITTED_GERBAGE_TYPE) === false) {
    set_error('不正なごみの種類が入力されています。');
    $is_valid = false;
  }
  return $is_valid;
}

// 申込者の電話番号
function is_valid_phone_number($phone_number)
{
  $is_valid = true;
  if (is_valid_format($phone_number, PERMITTED_PHONE_NUMBER) === false) {
    set_error('電話番号は10または11桁の半角数字、ハイフンなしで入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

// 申込者のメールアドレス
function is_valid_email($email)
{
  $is_valid = true;
  if (is_valid_format($email, PERMITTED_EMAIL) === false) {
    set_error('メールアドレスの形式が間違っています。');
    $is_valid = false;
  }
  return $is_valid;
}

// 申込者の区以下の住所
function is_valid_address($address)
{
  $is_valid = true;
  if (is_valid_length($address, ADDRESS_LENGTH_MIN, ADDRESS_LENGTH_MAX) === false) {
    set_error('以下の住所は' . ADDRESS_LENGTH_MIN . '文字以上、' . ADDRESS_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}

// ごみの情報（種類、ステータス、区）の番号を名前に変換
function garbages_information_numbers_to_name($garbages)
{
  // 空の配列が渡された時はそのまま返す
  if(count($garbages) <= 0){
    return [];
  }

  // 1つずつごみの情報（種類、ステータス、区）の番号を変換。ごみ管理画面でステータスによって色を変えるため色も指定。
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

// ごみのステータスによって背景色を指定
function bg_color_by_status($status)
{
  switch ($status) {
    case 0:
      $bg_color = '#d9edf7';
      break;
    case 1:
      $bg_color = '#dff0d8';
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
