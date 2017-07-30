<?php
require_once '../util/defineUtil.php';
?>
<!-- ログインチェックボタン -->
<form name="login" action="<?php echo LOGIN ?>" method="post">
    <input type="hidden" name="before_page" value="<?php echo basename($_SERVER["PHP_SELF"]) ?>">
</form>
<br>
<?php
if (isset($_SESSION["login_name"])) {
    ?>
    <a href="<?php echo LOGIN ?>" onclick="document.login.submit();return false;">ログアウト</a><br>
    <a href="<?php echo CART ?>">買い物かご</a><br>
    ようこそ
    <a href="<?php echo MY_DATA ?>"><?php echo $_SESSION["login_name"]; ?></a>
    さん！<br>
    <?php
} else {
    ?>
    <a href="<?php echo LOGIN ?>" onclick="document.login.submit();return false;">ログイン</a><br>
    ようこそゲストさん！<br>
    <?php
}
?>