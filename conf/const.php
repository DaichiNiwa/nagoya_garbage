<?php
// 変数を定義
$type;
$comment;
$username;
$phone_number;
$email;
$area;
$address;
$garbages = [];
// ごみの回収日は申込日の次の水曜とする
$collect_day = new DateTime('next wednesday');

// ドキュメントルート
define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../model/');
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../view/');

define('STYLESHEET_PATH', '/assets/css/');

// データベース接続
define('DB_HOST', 'mysql');
define('DB_NAME', 'sample');
define('DB_USER', 'testuser');
define('DB_PASS', 'password');
define('DB_CHARSET', 'utf8');

// URL
define('REGISTER_URL', '/register/register.php');
define('CONFIRM_URL', '/register/confirm.php');
define('FINISH_URL', '/register/finish.php');
define('ADMIN_LOGIN_URL', '/admin/login.php');
define('ADMIN_LOGOUT_URL', '/admin/logout.php');
define('ADMIN_GARBAGES_URL', '/admin/garbages/garbages.php');
define('ADMIN_ADMIN_URL', '/admin/admin.php');
define('ADMIN_USERS_URL', '/admin/users/users.php');
define('ADMIN_WORKERS_URL', '/admin/workers/workers.php');
define('WORKER_LOGIN_URL', '/worker/login.php');
define('WORKER_LOGOUT_URL', '/worker/logout.php');
define('WORKER_GARBAGES_URL', '/worker/garbages.php');

// バリデーション文字制限
define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/');
define('REGEXP_POSITIVE_INTEGER', '/\A([1-9][0-9]*|0)\z/');

// ごみのステータス（0から4の数字)
define('PERMITTED_GERBAGE_STATUS', '/\A[0-4]\z/');
// ごみのタイプ（0から6の数字)
define('PERMITTED_GERBAGE_TYPE', '/\A[0-6]\z/');
// 区のタイプ（0から12の数字)
define('PERMITTED_AREA_TYPE', '/\A([0-9]|1[0-2])\z/');
// 電話番号（先頭が0の10桁または11桁の半角数字）
define('PERMITTED_PHONE_NUMBER', '/\A0[0-9]{9}[0-9]?\z/');
// メールアドレス
define('PERMITTED_EMAIL', '/\A[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+\z/');


define('NAME_LENGTH_MIN', 2);
define('NAME_LENGTH_MAX', 20);
define('PASSWORD_LENGTH_MIN', 5);
define('PASSWORD_LENGTH_MAX', 10);
define('LOGIN_ID_LENGTH_MIN', 5);
define('LOGIN_ID_LENGTH_MAX', 10);
define('ADDRESS_LENGTH_MIN', 3);
define('ADDRESS_LENGTH_MAX', 30);
define('COMMENT_LENGTH_MAX', 200);
// ごみ管理画面での表示数
define('DISPLAY_GARBAGES_NUMBER', 10);

// 発行するトークンの長さを指定
define('TOKEN_LENGTH', 20);

// define('USER_TYPE_ADMIN', 1);
// define('USER_TYPE_NORMAL', 2);

// define('ITEM_NAME_LENGTH_MIN', 1);
// define('ITEM_NAME_LENGTH_MAX', 100);

// define('ITEM_STATUS_OPEN', 1);
// define('ITEM_STATUS_CLOSE', 0);

// define('PERMITTED_ITEM_STATUSES', array(
//   'open' => 1,
//   'close' => 0,
// ));
