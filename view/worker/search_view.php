<!DOCTYPE html>
<html lang="ja">

<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>条件検索/名古屋市粗大ごみ</title>
</head>

<body>
  <?php include VIEW_PATH . 'templates/header_worker_login.php';?>

  <div class="container">
    <h1>条件検索（作業員用）</h1>
    <h2 class="border-bottom border-primary">検索結果</h2>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <p class="m-0">ごみのステータスと区を指定して検索</p>
    <form method="post" action="garbage_search.php" class="row">
      <select class="form-control col-4 m-2" name="status" id="status">
        <option value="" <?php if($status === '') { print h('selected');} ?>>選択なし</option>
        <option value="0" <?php if($status === '0') { print h('selected');} ?>>未回収</option>
        <option value="1" <?php if($status === '1') { print h('selected');} ?>>回収済</option>
        <option value="2" <?php if($status === '2') { print h('selected');} ?>>回収前保留</option>
        <option value="3" <?php if($status === '3') { print h('selected');} ?>>回収後保留</option>
        <option value="4" <?php if($status === '4') { print h('selected');} ?>>回収不可</option>
      </select>
      <select class="form-control col-4 m-2" name="area" id="area">
          <option value="" <?php if($area === '') { print h('selected');} ?>>選択なし</option>
          <option value="0" <?php if($area === '0') { print h('selected');} ?>>千種区</option>
          <option value="1" <?php if($area === '1') { print h('selected');} ?>>東区</option>
          <option value="2" <?php if($area === '2') { print h('selected');} ?>>北区</option>
          <option value="3" <?php if($area === '3') { print h('selected');} ?>>西区</option>
          <option value="4" <?php if($area === '4') { print h('selected');} ?>>中村区</option>
          <option value="5" <?php if($area === '5') { print h('selected');} ?>>中区</option>
          <option value="6" <?php if($area === '6') { print h('selected');} ?>>昭和区</option>
          <option value="7" <?php if($area === '7') { print h('selected');} ?>>瑞穂区</option>
          <option value="8" <?php if($area === '8') { print h('selected');} ?>>熱田区</option>
          <option value="9" <?php if($area === '9') { print h('selected');} ?>>中川区</option>
          <option value="10" <?php if($area === '10') { print h('selected');} ?>>港区</option>
          <option value="11" <?php if($area === '11') { print h('selected');} ?>>名東区</option>
          <option value="12" <?php if($area === '12') { print h('selected');} ?>>天白区</option>
      </select>
      <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
      <input type="submit" value="条件を指定して検索" class="btn btn-warning col-3 m-2">
    </form>
    <div class="row">
      <p class="col-4 m-2">ステータス：<?php print h(status_number_to_name($status)); ?></p>
      <p class="col-4 m-2">区：<?php print h(area_number_to_name($area)); ?></p>
      <a class="col-3 btn btn-secondary m-2" href="<?php print h(WORKER_GARBAGES_URL); ?>">一覧に戻る</a>
    </div>
    <p><?php print h($garbages_amount); ?>件見つかりました。</p>

    <?php if(($garbages_amount) > 0){ ?>
      <div class="text-center">
        <?php foreach($garbages as $garbage){ ?>
          <div class="border border-primary" style="background-color: <?php print h($garbage['bg_color']); ?>;">
          
            <div class="row m-0">
              <div class="col-md-2 border"><?php print h($garbage['garbage_id']); ?></div>
              <div class="col-md-2 border"><?php print h($garbage['type']); ?></div>
              <div class="form-group col-md-3 border m-0">
                <form method="post" action="garbage_change_status.php" class="row">
                  <select class="form-control col" name="status" id="status">
                    <option value="0" <?php if($garbage['status'] === 0) { print h('selected');} ?>>未回収</option>
                    <option value="1" <?php if($garbage['status'] === 1) { print h('selected');} ?>>回収済</option>
                    <option value="2" <?php if($garbage['status'] === 2) { print h('selected');} ?>>回収前保留</option>
                    <option value="3" <?php if($garbage['status'] === 3) { print h('selected');} ?>>回収後保留</option>
                    <option value="4" <?php if($garbage['status'] === 4) { print h('selected');} ?>>回収不可</option>
                  </select>
                  <input type="hidden" name="garbage_id" value="<?php print h($garbage['garbage_id']); ?>">
                  <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                  <input type="submit" value="変更" class="btn mb-0 btn-secondary">
                </form>
              </div>
              <div class="col-md-3 border">
                <form method="post" action="garbage_change_status.php">
                  <input type="hidden" name="status" value="1">
                  <input type="hidden" name="garbage_id" value="<?php print h($garbage['garbage_id']); ?>">
                  <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                  <input type="submit" value="回収済に変更" class="btn mb-0 btn-info">
                </form>
              </div>
              <div class="col-md-2 border">
                <button type="button" class="btn mb-0 btn-success" data-toggle="popover" data-html="true" data-content="
                  <?php print h($garbage['username'] . '<br/>' . $garbage['phone_number'] . '<br/>' . $garbage['email']);?>"
                data-placement="top">詳細</button>
              </div>
            </div>
            
            <div class="row m-0">
              <div class="col-md-2 border"><?php print h($garbage['area']); ?></div>
              <div class="col-md-10 border"><?php print h($garbage['address']); ?></div>
            </div>
            
            <div class="row m-0">
              <div class="col-md-4 border">回収: <?php print h($garbage['collect_day']); ?></div>
              <div class="col-md-5 border">担当者: <?php print h($garbage['worker_name']); ?></div>
              <div class="col-md-3 border">
                <button type="button" class="btn mb-0 btn-warning" data-toggle="modal" data-target="#modal-<?php print h($garbage['garbage_id']); ?>">コメント記入</button>
              </div>
            </div>

            <?php if(has_comment($garbage['user_comment'], $garbage['admin_comment'], $garbage['worker_comment'])){; ?>
              <div class="row m-0">
                <div class="col-md-4 border">
                  <p class="border-bottom">ユーザコメント</p>
                  <?php print h($garbage['user_comment']); ?>
                </div>
                <div class="col-md-4 border">
                  <p class="border-bottom">管理者コメント</p>
                  <?php print h($garbage['admin_comment']); ?>
                </div>
                <div class="col-md-4 border">
                  <p class="border-bottom">作業員コメント</p>
                  <?php print h($garbage['worker_comment']); ?>
                </div>
              </div>
            <?php } ?>
          </div>

          <!-- コメント入力用モーダル -->
          <div class="modal fade" id="modal-<?php print h($garbage['garbage_id']); ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="post" action="garbage_change_comment.php" class="p-2">
                  <p>コメント記入（200文字以内）</p>
                  <div class="form-group">
                    <textarea class="form-control" type="text" name="comment" id="comment"><?php if (isset($garbage['worker_comment'])) {print h($garbage['worker_comment']);} ?></textarea>
                  </div>
                  <input type="submit" value="記入" class="btn mb-0 btn-secondary">
                  <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                  <input type="hidden" name="garbage_id" value="<?php print h($garbage['garbage_id']); ?>">
                </form> 
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } ?> 
  </div> 

  <script>
    $('[data-toggle="popover"]').popover()
  </script>
</body>
</html>