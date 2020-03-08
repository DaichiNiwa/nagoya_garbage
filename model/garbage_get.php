<?php
require_once 'functions.php';
require_once 'db.php';
require_once 'garbage_function.php';

// ごみの取得
function get_garbages($db, $current_page){
  $list_start_number = DISPLAY_GARBAGES_NUMBER * ($current_page - 1);
  return get_designated_garbages($db, $list_start_number);
}

function get_designated_garbages($db, $list_start_number = 0){
  $sql = '
    SELECT
      garbage_id, 
      status,
      type,
      collect_day,
      username,
      phone_number,
      email,
      area,
      address,
      user_comment,
      admin_comment,
      worker_comment
    FROM
      garbages
    LIMIT :list_start_number,
  ' . DISPLAY_GARBAGES_NUMBER;

    $params = array(
      ':list_start_number' => $list_start_number
    );

  return fetch_all_query($db, $sql, $params);
}

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

// ユーザの名前でごみを検索
function get_garbages_by_username($db, $username){
  $sql = "
    SELECT
      garbage_id, 
      status,
      type,
      collect_day,
      username,
      phone_number,
      email,
      area,
      address,
      user_comment,
      admin_comment,
      worker_comment
    FROM
      garbages
    WHERE
      username
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
    unset($_SESSION['__errors']);
    return $garbages;
  }

  // 区のみ入力されている時
  if ($status === '' && is_valid_area($area) === true) {
    $garbages = get_garbages_by_area($db, $area);
    unset($_SESSION['__errors']);
    return $garbages;
  }

  unset($_SESSION['__errors']);
  set_error('検索に失敗しました。');
  redirect_to(ADMIN_GARBAGES_URL);
}

// ステータスと区の両方が入力されている時
function get_garbages_by_status_area($db, $status, $area){
  $sql = '
    SELECT
      garbage_id, 
      status,
      type,
      collect_day,
      username,
      phone_number,
      email,
      area,
      address,
      user_comment,
      admin_comment,
      worker_comment
    FROM
      garbages
    WHERE
      status = :status
    AND
      area = :area
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
      garbage_id, 
      status,
      type,
      collect_day,
      username,
      phone_number,
      email,
      area,
      address,
      user_comment,
      admin_comment,
      worker_comment
    FROM
      garbages
    WHERE
      status = :status
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
      garbage_id, 
      status,
      type,
      collect_day,
      username,
      phone_number,
      email,
      area,
      address,
      user_comment,
      admin_comment,
      worker_comment
    FROM
      garbages
    WHERE
      area = :area
  ';

    $params = array(
      ':area' => $area,
    );

  return fetch_all_query($db, $sql, $params);
}