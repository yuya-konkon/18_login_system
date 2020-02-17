<?php

require_once('config.php');
require_once('functions.php');

session_start();

if (empty($_SESSION['id'])) {
  header('Location: login.php');
  exit;
}

$dbh = connectDb();
$sql = "select * from users where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $_SESSION['id']);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員限定画面</title>
</head>

<body>
  <h1>登録したユーザーのみ閲覧可能です！</h1>
  <h2><?php echo h($user['name']); ?>さん ようこそ！</h2>
  <p><a href="logout.php">ログアウト</a></p>
</body>

</html>