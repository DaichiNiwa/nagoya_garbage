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

function get_get($name)
{
  if (isset($_GET[$name]) === true) {
    return $_GET[$name];
  };
  return '';
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

function has_error()
{
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
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

function is_logined()
{
  return get_session('user_id') !== '';
}

function get_random_string($length = 20)
{
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX)
{
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}

function is_alphanumeric($string)
{
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

function is_positive_integer($string)
{
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

function is_valid_format($string, $format)
{
  return preg_match($format, $string) === 1;
}

// トークンの生成
function get_csrf_token()
{
  // get_random_string()はユーザー定義関数。
  $token = get_random_string(TOKEN_LENGTH);
  // set_session()はユーザー定義関数。
  set_session('csrf_token', $token);
  return $token;
}

//  トークンのチェック
function is_valid_csrf_token($token)
{
  if ($token === '') {
    return false;
  }
  // get_session()はユーザー定義関数。
  return $token === get_session('csrf_token');
}
