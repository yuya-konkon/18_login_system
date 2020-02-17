<?php

require_once('config.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $name = $_POST['name'];
  $password = $_POST['password'];

  $errors = [];

  // バリデーション
  if ($email == '') {
    $errors[] = 'メールアドレスが未入力です';
  }

  if ($name == '') {
    $errors[] = 'ユーザー名が未入力です';
  }

  if ($password == '') {
    $errors[] = 'パスワードが未入力です';
  }

  if (empty($errors)) {
    $dbh = connectDb();

    $sql = "insert into users (email, name, password, created_at) values (:email, :name, :password, now()) ";

    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':name', $name);
    // パスワードのハッシュ化
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $pw_hash);

    $stmt->execute();

    header('Location: login.php');
    exit;
  }
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録画面</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <h1>新規ユーザー登録</h1>
  <?php if ($errors) : ?>
    <ul class="error-list">
      <?php foreach ($errors as $error) : ?>
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form action="" method="post">
    <label for="email">メールアドレス:
      <input type="email" name="email" id="" value="<?php echo h($email); ?>">
    </label>
    <br>
    <label for=" name">ユーザー名:
      <input type="text" name="name" id="" value="<?php echo h($name); ?>">
    </label>
    <br>
    <label for=" password">パスワード:
      <input type="text" name="password" id="">
    </label>
    <br>
    <input type="submit" value="新規登録">
  </form>
  <a href="login.php">ログインはこちら</a>
</body>

</html>