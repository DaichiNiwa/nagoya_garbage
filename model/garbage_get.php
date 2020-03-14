<?php
require_once 'functions.php';
require_once 'db.php';
require_once 'garbage_function.php';

// ごみ管理画面で表示するように取得
function get_garbages($db, $current_page){
  $list_start_number = DISPLAY_ITEMS_NUMBER * ($current_page - 1);
  return get_designated_garbages($db, $list_start_number);
}

// ごみ管理画面で１０件ずつ表示するように取得
function get_designated_garbages($db, $list_start_number = 0){
  $sql = '
    SELECT
      garbages.garbage_id, 
      garbages.status,
      garbages.type,
      garbages.collect_day,
      garbages.username,
      garbages.phone_number,
      garbages.email,
      garbages.area,
      garbages.address,
      garbages.user_comment,
      garbages.admin_comment,
      garbages.worker_comment,
      workers.worker_name
    FROM
      garbages
    LEFT OUTER JOIN
      workers
    ON
      garbages.worker_id = workers.worker_id
    LIMIT :list_start_number,
  ' . DISPLAY_ITEMS_NUMBER;

    $params = array(
      ':list_start_number' => $list_start_number
    );

  return fetch_all_query($db, $sql, $params);
}

// ユーザの名前でごみを検索
function get_garbages_by_username($db, $username){
  $sql = "
    SELECT
      garbages.garbage_id, 
      garbages.status,
      garbages.type,
      garbages.collect_day,
      garbages.username,
      garbages.phone_number,
      garbages.email,
      garbages.area,
      garbages.address,
      garbages.user_comment,
      garbages.admin_comment,
      garbages.worker_comment,
      workers.worker_name
    FROM
      garbages
    LEFT OUTER JOIN
      workers
    ON
      garbages.worker_id = workers.worker_id
    WHERE
      garbages.username
    LIKE
      :username
    ESCAPE
      '!'
  ";

  try {
    $statement = $db->prepare($sql);
    $statement->bindValue(':username', '%' . preg_replace('/(?=[!_%])/', '!', $username) . '%', PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll();
  } catch (PDOException $e) {
    set_error('データ取得に失敗しました。');
  }
  return false;
}

// 検索条件に合わせてごみを取得
function get_searched_garbages($db, $status, $area){
  // ステータスと区の両方が入力されている時
  if (is_valid_garbage_status($status) === true && is_valid_area($area) === true) {
    $garbages = get_garbages_by_status_area($db, $status, $area);
    return $garbages;
  }

  // ステータスのみ入力されている時
  if (is_valid_garbage_status($status) === true && $area === '') {
    $garbages = get_garbages_by_status($db, $status);
    // 一つ上のバリデーションでエラーメッセージがセットされている場合があるので、ここでアンセット
    unset($_SESSION['__errors']);
    return $garbages;
  }

  // 区のみ入力されている時
  if ($status === '' && is_valid_area($area) === true) {
    $garbages = get_garbages_by_area($db, $area);
    // 上2つのバリデーションでエラーメッセージがセットされている場合があるので、ここでアンセット
    unset($_SESSION['__errors']);
    return $garbages;
  }

    // 上記３つのパターンに当てはまらない場合、不正な値が渡されているとして、エラーメッセージをアンセットした上でfalseを返す
  unset($_SESSION['__errors']);
  set_error('検索に失敗しました。');
  return false;
}

// ステータスと区の両方が入力されている時
function get_garbages_by_status_area($db, $status, $area){
  $sql = '
    SELECT
      garbages.garbage_id, 
      garbages.status,
      garbages.type,
      garbages.collect_day,
      garbages.username,
      garbages.phone_number,
      garbages.email,
      garbages.area,
      garbages.address,
      garbages.user_comment,
      garbages.admin_comment,
      garbages.worker_comment,
      workers.worker_name
    FROM
      garbages
    LEFT OUTER JOIN
      workers
    ON
      garbages.worker_id = workers.worker_id
    WHERE
      garbages.status = :status
    AND
      garbages.area = :area
  ';

    $params = array(
      ':status' => $status,
      ':area' => $area,
    );

  return fetch_all_query($db, $sql, $params);
}

// ステータスのみ入力されている時
function get_garbages_by_status($db, $status){
  $sql = '
    SELECT
      garbages.garbage_id, 
      garbages.status,
      garbages.type,
      garbages.collect_day,
      garbages.username,
      garbages.phone_number,
      garbages.email,
      garbages.area,
      garbages.address,
      garbages.user_comment,
      garbages.admin_comment,
      garbages.worker_comment,
      workers.worker_name
    FROM
      garbages
    LEFT OUTER JOIN
      workers
    ON
      garbages.worker_id = workers.worker_id
    WHERE
      garbages.status = :status
  ';

    $params = array(
      ':status' => $status
    );

  return fetch_all_query($db, $sql, $params);
}

// 区のみ入力されている時
function get_garbages_by_area($db, $area){
  $sql = '
    SELECT 
      garbages.garbage_id, 
      garbages.status,
      garbages.type,
      garbages.collect_day,
      garbages.username,
      garbages.phone_number,
      garbages.email,
      garbages.area,
      garbages.address,
      garbages.user_comment,
      garbages.admin_comment,
      garbages.worker_comment,
      workers.worker_name
    FROM
      garbages
    LEFT OUTER JOIN
      workers
    ON
      garbages.worker_id = workers.worker_id
    WHERE
      garbages.area = :area
  ';

    $params = array(
      ':area' => $area,
    );

  return fetch_all_query($db, $sql, $params);
}

// 地域を指定してごみの取得
function get_assigned_garbages($db, $current_page, $area){
  $list_start_number = DISPLAY_ITEMS_NUMBER * ($current_page - 1);
  return get_designated_area_garbages($db, $list_start_number, $area);
}

// 地域を指定してごみ管理画面で１０件ずつ表示するように取得
function get_designated_area_garbages($db, $list_start_number = 0, $area){
  $sql = '
    SELECT
      garbages.garbage_id, 
      garbages.status,
      garbages.type,
      garbages.collect_day,
      garbages.username,
      garbages.phone_number,
      garbages.email,
      garbages.area,
      garbages.address,
      garbages.user_comment,
      garbages.admin_comment,
      garbages.worker_comment,
      workers.worker_name
    FROM
      garbages
    LEFT OUTER JOIN
      workers
    ON
      garbages.worker_id = workers.worker_id
    WHERE
      garbages.area = :area
    LIMIT :list_start_number,
  ' . DISPLAY_ITEMS_NUMBER;

    $params = array(
      ':area' => $area,
      ':list_start_number' => $list_start_number
    );

  return fetch_all_query($db, $sql, $params);
}

// ごみの総数を取得
function get_all_garbages_amount($db){
  $sql = '
    SELECT
      COUNT(garbage_id) as count
    FROM
      garbages
  ';
  $all_garbages_amount = fetch_query($db, $sql);
  return $all_garbages_amount['count'];
}

// 作業員の担当地域ごとのごみ総数を取得
function get_assigned_garbages_amount($db, $area){
  $sql = '
    SELECT
      COUNT(garbage_id) as count
    FROM
      garbages
    WHERE
      area = :area
  ';

  $params = array(
    ':area' => $area
  );

  $all_garbages_amount = fetch_query($db, $sql, $params);
  return $all_garbages_amount['count'];
}