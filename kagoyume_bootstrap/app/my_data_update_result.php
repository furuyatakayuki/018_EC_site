<?php
require_once "../util/scriptUtil.php";
require_once "../util/dbaccesUtil.php";

session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<head>
    <meta charset="utf-8">
    <title>登録結果</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/add.css">
</head>
<body>
<?php require_once '../util/header.php'; ?>
<?php
// ログインチェック
if (isset($_SESSION["login_name"], $_SESSION["login_id"])){
} else {
    ?>
    <div class="alert-info h4 text-center"><p style="padding: 10px;">ログインしてください</p></div>
    <?php
    header("Location: " . LOGIN);
    exit;
}
?>
    <?php
    if (!isset($_POST["mode"]) || !$_POST["mode"] == "UPDATE"){
        ?>
        <div class="alert-danger h4 text-center"><p style="padding: 10px;">アクセスルートが不正です。<br>もう一度やり直してください。</p></div>
        <?php
    } else {
        $login_id = $_SESSION["login_id"];
        $update_name = $_POST["update_name"];
        $update_pass = password_hash($_POST["update_pass"], PASSWORD_DEFAULT);
        $update_mail = $_POST["update_mail"];
        $update_address = $_POST["update_address"];

        if (empty($_POST["update_name"]) || empty($_POST["update_pass"]) || empty($_POST["update_mail"]) || empty($_POST["update_address"])) {
            $user_data = get_my_data($login_id);
            if (is_array($user_data) && (count($user_data > 0))) {
                if (empty($_POST["update_name"])) {
                    $update_name = $user_data[0]["name"];
                }
                if (empty($_POST["update_pass"])) {
                    $update_pass = $user_data[0]["password"];
                }
                if (empty($_POST["update_mail"])) {
                    $update_mail = $user_data[0]["mail"];
                }
                if (empty($_POST["update_address"])) {
                    $update_address = $user_data[0]["address"];
                }
            } else {
                ?>
                <div class="alert-danger h4 text-center"><p style="padding: 10px;">エラーです<br><?php echo $user_data; ?></p></div>
                <?php
            }
        }

        $result = update_users($login_id, $update_name, $update_pass, $update_mail, $update_address);

        if (!isset($result)) {
            // 更新成功時、ログイン中の名称も変更する。
            $_SESSION["login_name"] = $_POST["update_name"];
            ?>
            <h1 class="text-center">更新結果結果</h1>
            <div class="container">
            <div class="col-md-offset-2 col-md-8">
            <table class="table table-bordered text-center">

            <?php
            if (!empty($_POST["update_name"]) || !empty($_POST["update_pass"]) || !empty($_POST["update_mail"]) || !empty($_POST["update_address"])) {
                if (!empty($_POST["update_name"])) {
                    ?><tr><td>ユーザ名</td><td><?php echo $update_name; ?></td></tr><?php
                }
                if (!empty($_POST["update_pass"])) {
                    ?><tr><td>パスワード</td><td><?php echo str_pad("", mb_strlen($_POST["update_pass"]), "*") ;?></td></tr><?php
                }
                if (!empty($_POST["update_mail"])) {
                    ?><tr><td>メールアドレス</td><td><?php echo $update_mail; ?></td></tr><?php
                }
                if (!empty($_POST["update_address"])) {
                    ?><tr><td>住所</td><td><?php echo $update_address; ?></td></tr><?php
                }
            } else {
                ?>
                <td colspan=2>変更内容はありませんでした</td>
                <?php
            }
            ?>

            </table>
            <p class="text-center">以上の内容で更新しました</p>
            </div>
        </div>
            <?php
        } else {
            ?>
            <div class="alert-danger h4 text-center"><p style="padding: 10px;">エラーです<br><?php echo $result; ?></p></div>
            <?php
        }
    }
    ?>
<?php require_once '../util/footer.php' ?>
</body>
</html>