<?php

function h($word)
{
  return htmlspecialchars($word, ENT_QUOTES, 'UTF-8');
}

function dd($var)
{
  var_dump($var);
  exit();
}

function redirect_to($url)
{
  header('Location: ' . $url);
  exit;
}

function get_get($name, $default = '')
{
  if (isset($_GET[$name]) === true) {
    return $_GET[$name];
  };
  return $default;
}

function get_post($name)
{
  if (isset($_POST[$name]) === true) {
    return $_POST[$name];
  };
  return '';
}

function get_session($name)
{
  if (isset($_SESSION[$name]) === true) {
    return $_SESSION[$name];
  };
  return '';
}

function set_session($name, $value)
{
  $_SESSION[$name] = $value;
}

function set_error($error)
{
  $_SESSION['__errors'][] = $error;
}

function get_errors()
{
  $errors = get_session('__errors');
  if ($errors === '') {
    return array();
  }
  set_session('__errors',  array());
  return $errors;
}

function set_message($message)
{
  $_SESSION['__messages'][] = $message;
}

function get_messages()
{
  $messages = get_session('__messages');
  if ($messages === '') {
    return array();
  }
  set_session('__messages',  array());
  return $messages;
}

// ごみ管理画面や作業員管理画面でのページ番号の取得
function get_current_page($total_pages_number){
  // ゲットでページ番号を取得。もし無ければ初期値として１を設定
  $current_page = (int)get_get('current_page', 1);

  // ゲットで不正なページ番号が入力された場合、ページ番号は１とする
  if(is_valid_current_page($current_page, $total_pages_number) === false){
    $current_page = 1;
  }
  return $current_page;
}

// ページ番号のバリデーション
function is_valid_current_page($current_page, $total_pages_number)
{
  $is_valid = true;
  // $current_pageが0以下の数字、または$total_pages_numberより大きいなら不正な値としてfalse
  if ($current_page <= 0 || $current_page > $total_pages_number) {
    $is_valid = false;
  }
  return $is_valid;
}

// 「xx件中 xx - xx件の〇〇」の表示のためのテキストを生成
function make_items_count_text($all_items_amount, $current_page, $item_name){
  $list_start_number = DISPLAY_ITEMS_NUMBER * ($current_page - 1) + 1;
  $list_end_number = $current_page * DISPLAY_ITEMS_NUMBER;
  // itemが1つもない場合
  if($all_items_amount === 0){
    return "{$item_name}がありません。";
  }
  // 最終ページでitemが１つしかない場合
  if($all_items_amount === $list_start_number){
    return "{$all_items_amount}件中 {$all_items_amount}件目の{$item_name}";
  }
  // 最終ページの場合
  if($all_items_amount < $list_end_number){
    return "{$all_items_amount}件中 {$list_start_number} - {$all_items_amount}件目の{$item_name}";
  }
  // 通常のページ  
  return "{$all_items_amount}件中 {$list_start_number} - {$list_end_number}件目の{$item_name}";
}

//ごみ管理画面や作業員管理画面でのページ数を算出
function calculate_total_pages_number($all_items_amount){
  return ceil($all_items_amount / DISPLAY_ITEMS_NUMBER);
}

// トークン発行用に文字列を取得
function get_random_string($length = 20)
{
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

// 文字列の長さのバリデーション
function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX)
{
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}

// 文字列の長さのバリデーション
function is_alphanumeric($string)
{
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

// 文字列が半角英数字であるか
function is_positive_integer($string)
{
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

// 正規表現でのチェックを行いtrueかfalseを返す
function is_valid_format($string, $format)
{
  return preg_match($format, $string) === 1;
}

// 区のバリデーション
function is_valid_area($area)
{
  $is_valid = true;
  if (is_valid_format($area, PERMITTED_AREA_TYPE) === false) {
    set_error('不正な区が入力されています。');
    $is_valid = false;
  }
  return $is_valid;
}

//コメントのバリデーション
function is_valid_comment($comment)
{
  $is_valid = true;
  if (is_valid_length($comment, 0, COMMENT_LENGTH_MAX) === false) {
    set_error('コメントは' . COMMENT_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}

// 名前を新規登録するときのバリデーション（最低でも苗字1文字、名前1文字として合計2文字が必要）
function is_valid_username($username)
{
  $is_valid = true;
  if (is_valid_length($username, NAME_LENGTH_MIN, NAME_LENGTH_MAX) === false) {
    set_error('氏名は' . NAME_LENGTH_MIN . '文字以上、' . NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}

// 名前で検索するときのバリデーション（1文字の苗字の人が検索されることがあるので最低１文字でよい）
function is_valid_search_username($username)
{
  $is_valid = true;
  if (is_valid_length($username, 1, NAME_LENGTH_MAX) === false) {
    set_error('検索する氏名は' . NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}

// ログインIDのバリデーション
function is_valid_login_id($login_id)
{
  $is_valid = true;
  if (is_valid_length($login_id, LOGIN_ID_LENGTH_MIN, LOGIN_ID_LENGTH_MAX) === false) {
    set_error('ログインIDは' . LOGIN_ID_LENGTH_MIN . '文字以上、' . LOGIN_ID_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }

  if (is_alphanumeric($login_id) === false) {
    set_error('ログインIDは半角英数字で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

// パスワード登録時のバリデーション
function is_valid_passwords($new_password, $confirm_new_password)
{
  $is_valid = true;

  if ($new_password !== $confirm_new_password) {
    set_error('新しいパスワードと新しいパスワード（確認）が一致しません。');
    $is_valid = false;
  }
  
  if (is_alphanumeric($new_password) === false) {
    set_error('新しいパスワードは半角英数字で入力してください。');
    $is_valid = false;
  }

  if (is_valid_length($new_password, PASSWORD_LENGTH_MIN, PASSWORD_LENGTH_MAX) === false) {
    set_error('新しいパスワードは' . PASSWORD_LENGTH_MIN . '文字以上、' . PASSWORD_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }

  return $is_valid;
}

// トークンの生成
function get_csrf_token()
{
  $token = get_random_string(TOKEN_LENGTH);
  set_session('csrf_token', $token);
  return $token;
}

//  トークンのチェック
function is_valid_csrf_token($token)
{
  if ($token === '') {
    return false;
  }
  return $token === get_session('csrf_token');
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