<!DOCTYPE html>
<html lang="ja">

<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>氏名検索/名古屋市粗大ごみ</title>
</head>

<body>
  <?php include VIEW_PATH . 'templates/header_admin_login.php';?>

  <div class="container">
    <h1>氏名検索（管理者用）</h1>
    <h2 class="border-bottom border-primary">検索結果</h2>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <form method="post" action="garbage_select_user.php">
      <div class="form-group row">
        <label for="username" class="col-4 m-2 text-center">ユーザの氏名で検索</label>
        <input class="form-control col-4 m-2" type="text" name="username" id="username" placeholder="例：田中太郎, 田中" value="<?php if (isset($username)) {print h($username);} ?>">
        <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
        <input type="submit" value="氏名を指定して検索" class="btn btn-success col-3 m-2">
      </div>
    </form>
    <div class="row">
      <p class="col-4 m-2 text-center">検索した氏名： <?php print h($username); ?></p>
      <p class="col-4 m-2"><?php print h($garbages_amount); ?>件見つかりました。</p>
      <a class="col-3 btn btn-secondary m-2" href="<?php print h(ADMIN_GARBAGES_URL); ?>">一覧に戻る</a>
    </div>

    <?php if($garbages_amount > 0){ ?>
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
              <div class="col-md-8 border"><?php print h($garbage['address']); ?></div>
              <div class="col-md-2 border">
                <form method="post" action="garbage_delete.php">
                  <input type="hidden" name="csrf_token" value="<?php print h($token); ?>">
                  <input type="hidden" name="garbage_id" value="<?php print h($garbage['garbage_id']); ?>">
                  <input type="submit" value="削除" class="btn mb-0 btn-danger delete">
                </form>
              </div>
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
                    <textarea class="form-control" type="text" name="comment" id="comment"><?php if (isset($garbage['admin_comment'])) {print h($garbage['admin_comment']);} ?></textarea>
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
    $('.delete').on('click', () => confirm('本当に削除しますか？'))
    $('[data-toggle="popover"]').popover()
  </script>
</body>
</html>
