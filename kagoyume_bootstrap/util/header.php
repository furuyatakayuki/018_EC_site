<?php
require_once '../util/defineUtil.php';
require_once '../util/yahoo_api_util.php';

$hits = array();
$query = !empty($_GET["query"]) ? $_GET["query"] : "";
$sort = !empty($_GET["sort"]) && array_key_exists($_GET["sort"], $sortOrder) ? $_GET["sort"] : "-score";
// $_GET無しでページに来たときの未定義を回避するためにnullを代入
if (!isset($_GET["category_id"])) {
    $_GET["category_id"] = null;
}
$category_id = ctype_digit($_GET["category_id"]) && array_key_exists($_GET["category_id"], $categories) ? $_GET["category_id"] : 1;

?>

<header style="background-color: #404040;">
<!-- ログインチェックボタン -->
<div class="container">
<div class="row row-center va-middle">
    <div class="col-md-2 padding_off">
            <span class="h1"><a href="<?php echo TOP_URL ?>"><font color="#FFFFFF">かごゆめ</font></a></span>
    </div>

    <div class="col-md-7 padding_off">
            <form action="<?php echo SEARCH ?>">
                <font color="#FFFFFF">表示順序:</font>
                <select name="sort">
                <?php foreach ($sortOrder as $key => $value) { ?>
                <option value="<?php echo h($key); ?>" <?php if($sort == $key) echo "selected=\"selected\""; ?>><?php echo h($value);?></option>
                <?php } ?>
                </select>
                <font color="#FFFFFF">キーワード検索：</font>
                <select name="category_id">
                <?php foreach ($categories as $id => $name) { ?>
                <option value="<?php echo h($id); ?>" <?php if($category_id == $id) echo "selected=\"selected\""; ?>><?php echo h($name);?></option>
                <?php } ?>
                </select>
                <input type="text" name="query" value="<?php echo h($query); ?>"/>
                <button type="submit" class="btn-warning">かごゆめ検索</button>
            </form>
    </div>

    <div class="col-md-3 padding_off">
            <form name="login" action="<?php echo LOGIN ?>" method="post">
                <input type="hidden" name="before_page" value="<?php echo basename($_SERVER["PHP_SELF"]) ?>">
            </form>
    
            <ul class="list-inline" style="margin-bottom: 0px;">
            <?php
            if (isset($_SESSION["login_name"])) {
                ?>
                <li><a href="<?php echo LOGIN ?>" onclick="document.login.submit();return false;"><font color="#FFFFFF">ログアウト</font></a></li>
                <li><font color="#FFFFFF">ようこそ
                <a href="<?php echo MY_DATA ?>"><font color="#FFFFFF"><?php echo $_SESSION["login_name"]; ?></font></a>
                さん！</font></li>
                <li><a href="<?php echo CART ?>"><font color="#FFFFFF">買い物かご</font></a></li>
                <?php
            } else {
                ?>
                <li><a href="<?php echo LOGIN ?>" onclick="document.login.submit();return false;"><font color="#FFFFFF">ログイン</font></a></li>
                <li><font color="#FFFFFF">ようこそゲストさん！</font></li>
                <li><a href="<?php echo CART ?>"><font color="#FFFFFF">買い物かご</font></a></li>
                <?php
            }
            ?>
            </ul>
    </div>
</div>
</div>
</header>
