<?php
require_once 'functions.php';
require_once 'db.php';

// DB利用

function get_garbage($db, $garbage_id){
  $sql = "
    SELECT
      garbage_id, 
      name,
      stock,
      price,
      image,
      phone_number
    FROM
      garbages
    WHERE
      garbage_id = :garbage_id
  ";

  $params = array(
    ':garbage_id' => $garbage_id
  );

  return fetch_query($db, $sql, $params);
}

function get_garbages($db, $is_open = false, $list_start_number = 0){
  $sql = '
    SELECT
      garbage_id, 
      name,
      stock,
      price,
      image,
      status
    FROM
      garbages
  ';

  // $is_openがfalseのときは管理画面での全商品表示、
  // trueのときは商品一覧画面で８つずつ表示するのを想定
  if($is_open === true){
    $sql .= '
      WHERE status = 1
      LIMIT :list_start_number,
    ' . DISPLAY_ITEMS_NUMBER;
    $params = array(
      ':list_start_number' => $list_start_number
    );
  }
  return fetch_all_query($db, $sql, $params);
}

function get_all_garbages($db){
  return get_garbages($db);
}

function get_open_garbages($db, $current_page){
  $list_start_number = DISPLAY_ITEMS_NUMBER * ($current_page - 1);
  return get_garbages($db, true, $list_start_number);
}

function get_all_garbages_amount($db){
  $sql = '
    SELECT
      COUNT(garbage_id) as count
    FROM
      garbages
    WHERE status = 1
  ';
  $all_garbages_amount = fetch_query($db, $sql);
  return $all_garbages_amount['count'];
}

function regist_garbage($db, $collect_day, $type, $comment, $username, $phone_number, $email, $area, $address){
  if(validate_garbage($type, $comment, $username, $phone_number, $email, $area, $address) === false){
    return false;
  }
  return regist_garbage_transaction($db, $collect_day, $type, $comment, $username, $phone_number, $email, $area, $address);
}

function regist_garbage_transaction($db, $collect_day, $type, $comment, $username, $phone_number, $email, $area, $address){
  $db->beginTransaction();
  if(insert_garbage($db, $collect_day, $type, $comment, $username, $phone_number, $email, $area, $address) ){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
  
}

function insert_garbage($db, $collect_day, $type, $comment, $username, $phone_number, $email, $area, $address){
  $sql = "
    INSERT INTO
      garbages(
        type,
        collect_day,
        username,
        phone_number,
        email,
        area,
        address,
        user_comment
      )
    VALUES(:type, :collect_day, :username, :phone_number, :email, :area, :address, :user_comment);
  ";

  $params = array(
    ':type' => $type,
    ':collect_day' => $collect_day,
    ':username' => $username,
    ':phone_number' => $phone_number,
    ':email' => $email,
    ':area' => $area,
    ':address' => $address,
    ':user_comment' => $comment,
  );

  return execute_query($db, $sql, $params);
}

function update_garbage_status($db, $garbage_id, $status){
  $sql = "
    UPDATE
      garbages
    SET
      status = :status
    WHERE
      garbage_id = :garbage_id
    LIMIT 1
  ";

  $params = array(
    ':status' => $status,
    ':garbage_id' => $garbage_id
  );

  return execute_query($db, $sql, $params);
}

function update_garbage_stock($db, $garbage_id, $stock){
  $sql = "
    UPDATE
      garbages
    SET
      stock = :stock
    WHERE
      garbage_id = :garbage_id
    LIMIT 1
  ";
  
  $params = array(
    ':stock' => $stock,
    ':garbage_id' => $garbage_id
  );

  return execute_query($db, $sql, $params);
}

function destroy_garbage($db, $garbage_id){
  $garbage = get_garbage($db, $garbage_id);
  if($garbage === false){
    return false;
  }
  $db->beginTransaction();
  if(delete_garbage($db, $garbage['garbage_id'])
    && delete_image($garbage['image'])){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
}

function delete_garbage($db, $garbage_id){
  $sql = "
    DELETE FROM
      garbages
    WHERE
      garbage_id = :garbage_id
    LIMIT 1
  ";

  $params = array(
    ':garbage_id' => $garbage_id
  );
  
  return execute_query($db, $sql, $params);
}


// 非DB

function is_open($garbage)
{
  return $garbage['status'] === 1;
}

// ごみの入力値のバリデーション
function validate_garbage($type, $comment, $username, $phone_number, $email, $area, $address)
{
  $is_valid_garbage_type = is_valid_garbage_type($type);
  $is_valid_garbage_comment = is_valid_garbage_comment($comment);
  $is_valid_username = is_valid_username($username);
  $is_valid_phone_number = is_valid_phone_number($phone_number);
  $is_valid_email = is_valid_email($email);
  $is_valid_area = is_valid_area($area);
  $is_valid_address = is_valid_address($address);

  return $is_valid_garbage_type
    && $is_valid_garbage_comment
    && $is_valid_username
    && $is_valid_phone_number
    && $is_valid_email
    && $is_valid_area
    && $is_valid_address;
}

// 個別の入力値のバリデーション
function is_valid_garbage_type($type)
{
  $is_valid = true;
  if (is_valid_format($type, PERMITTED_GERBAGE_TYPE) === false) {
    set_error('不正なごみの種類が入力されています。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_garbage_comment($comment)
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
    case 0:
      $area_name = '千種区';
      break;
    case 1:
      $area_name = '東区';
      break;
    case 2:
      $area_name = '北区';
      break;
    case 3:
      $area_name = '西区';
      break;
    case 4:
      $area_name = '中村区';
      break;
    case 5:
      $area_name = '中区';
      break;
    case 6:
      $area_name = '昭和区';
      break;
    case 7:
      $area_name = '瑞穂区';
      break;
    case 8:
      $area_name = '熱田区';
      break;
    case 9:
      $area_name = '中川区';
      break;
    case 10:
      $area_name = '港区';
      break;
    case 11:
      $area_name = '名東区';
      break;
    case 12:
      $area_name = '天白区';
      break;
    default:
      $area_name = false;
      break;
  }
  return $area_name;
}
