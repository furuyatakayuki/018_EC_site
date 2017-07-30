<?php
require_once '../util/defineUtil.php';

//DBへの接続を行う。成功ならPDOオブジェクトを、失敗なら中断、メッセージの表示を行う
function connect2MySQL(){
    try{
        $pdo = new PDO(DNS, USER_NAME, PASSWORD);
        //SQL実行時のエラーをtry-catchで取得できるように設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('DB接続に失敗しました。次記のエラーにより処理を中断します:'.$e->getMessage());
    }
}

// ログインのための関数。ユーザ名を引き数として、そのユーザのレコードを返す。
function login_check($user_name){
    // db接続を確立
    $login_db = connect2MySQL();

    $login_sql = "SELECT * FROM kagoyume_db WHERE mail = :user_name";

    // クエリとして用意
    $login_query = $login_db->prepare($login_sql);
    $login_query->bindValue(":user_name", $user_name);

    try {
        $login_query->execute();
    } catch (PDOException $e) {
        $login_db = null;
        return $e->getMessage();
    }

    $login_db = null;
    return $login_query->fetchAll(PDO::FETCH_ASSOC);
}

// 新規登録用関数。
function insert_users($name, $pass, $mail, $address){
    // db接続を確立
    $insert_db = connect2MySQL();

    $insert_sql = "INSERT INTO kagoyume_db(name, password, mail, address, total, newDate, deleteFlg) VALUES(:name, :password, :mail, :address, :total, :newDate, :deleteFlg)";

    // クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);

    $datetime = new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');

    $insert_query->bindValue(':name', $name);
    $insert_query->bindValue(':password', $pass);
    $insert_query->bindValue(':mail', $mail);
    $insert_query->bindValue(':address', $address);
    $insert_query->bindValue(':total', 0);
    $insert_query->bindValue(':newDate', $date);
    $insert_query->bindValue(':deleteFlg', 0);

    // SQLを実行
    try {
        $insert_query->execute();
    } catch (PDOException $e) {
        $insert_db = null;
        return $e->getMessage();
    }

    $insert_db = null;
    return null;
}

// mydataの取得
function get_my_data($id){
    // db接続を確立
    $mydata_db = connect2MySQL();

    $mydata_sql = "SELECT * FROM kagoyume_db WHERE userID = :userID";

    // クエリとして用意
    $mydata_query = $mydata_db->prepare($mydata_sql);

    $mydata_query->bindValue(':userID', $id);

    try {
        $mydata_query->execute();
    } catch (PDOException $e) {
        $mydata_db = null;
        return $e->getMessage();
    }

    // $mydata_db = null;
    return $mydata_query->fetchAll(PDO::FETCH_ASSOC);
}

// 購入履歴の取得
function get_my_history($id){
    // db接続を確立
    $my_history_db = connect2MySQL();

    $my_history_sql = "SELECT * FROM buy_t WHERE userID = :userID";

    $my_history_query = $my_history_db->prepare($my_history_sql);
    $my_history_query->bindValue(':userID', $id);

    try {
        $my_history_query->execute();
    } catch (PDOException $e) {
        $my_history_db = null;
        return $e->getMessage();
    }

    // $my_history_db = null;
    return $my_history_query->fetchAll(PDO::FETCH_ASSOC);
}

// ユーザ情報の更新
function update_users($id, $name, $pass, $mail, $address){
    // db接続を確立
    $update_db = connect2MySQL();

    $update_sql = "UPDATE kagoyume_db SET name = :name, password = :password, mail = :mail, address = :address, newDate = :newDate WHERE userID = :userID";

    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');

    $update_query = $update_db->prepare($update_sql);

    $update_query->bindValue(':name', $name);
    $update_query->bindValue(':password', $pass);
    $update_query->bindValue(':mail', $mail);
    $update_query->bindValue(':address', $address);
    $update_query->bindValue(':newDate', $date);
    $update_query->bindValue(':userID', $id);

    try {
        $update_query->execute();
    } catch (PDOException $e) {
        $update_db = null;
        return $e->getMessage();
    }

    $update_db = null;
    return null;
}

// ユーザ情報の削除(フラグをたてる)
function delete_users($id){
    // db接続を確立
    $delete_db = connect2MySQL();

    $delete_sql = "UPDATE kagoyume_db SET deleteFlg = 1 WHERE userID = :userID";

    // クエリとして用意
    $delete_query = $delete_db->prepare($delete_sql);

    $delete_query->bindValue(':userID', $id);

    try {
        $delete_query->execute();
    } catch (PDOException $e) {
        $delete_db = null;
        return $e->getMessage();
    }

    $delete_db = null;
    return null;
}

// 購入を確定しデータを保存。ユーザの総購入額も更新。
function buy_complete($id, $itemcode, $type){
    // db接続を確立
    $kagoyume_db = connect2MySQL();

    // $kagoyume_buy_sql = "INSERT INTO buy_t(userID, itemCode, type, buyDate) VALUES(:userID, :itemCode, :type, :buyDate)";
    $kagoyume_buy_sql = "INSERT INTO buy_t(userID, itemCode, type, buyDate) VALUES";

    $count = 0;
    foreach ($itemcode as $value) {
        $kagoyume_buy_sql .= "(:userID_$count, :itemCode_$count, :type_$count, :buyDate_$count), ";
        $count++;
    }
    $kagoyume_buy_sql = substr($kagoyume_buy_sql, 0, -2);

    // echo "SQL文：" . $kagoyume_buy_sql . "<br>";

    // クエリとして用意
    $kagoyume_query = $kagoyume_db->prepare($kagoyume_buy_sql);

    $datetime = new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');

    $count = 0;
    foreach ($itemcode as $value) {
        $kagoyume_query->bindValue(':userID_' . $count, $id);
        $kagoyume_query->bindValue(':itemCode_' . $count, $value);
        $kagoyume_query->bindValue(':type_' . $count, $type);
        $kagoyume_query->bindValue(':buyDate_' . $count, $date);
        $count++;
    }

    // 実行
    try {
        $kagoyume_query->execute();
    } catch (PDOException $e) {
        $kagoyume_db = null;
        return $e->getMessage();
    }

    $kagoyume_db = null;
    return null;
}

// 購入額総額を更新
function total_price($id, $price){
    $kagoyume_db = connect2MySQL();

    // 現在価格を取得
    $kagoyume_total_sql_1 = "SELECT total FROM kagoyume_db WHERE userID = :userID";
    $kagoyume_query = $kagoyume_db->prepare($kagoyume_total_sql_1);
    $kagoyume_query->bindValue(':userID', $id);

    try {
        $kagoyume_query->execute();
    } catch (PDOException $e) {
        $kagoyume_db = null;
        return $e->getMessage();
    }

    $total = $kagoyume_query->fetchAll(PDO::FETCH_ASSOC);

    // 価格を合計したものを更新
    $kagoyume_total_sql_2 = "UPDATE kagoyume_db SET total = :total WHERE userID = :userID";
    $kagoyume_query = $kagoyume_db->prepare($kagoyume_total_sql_2);
    $kagoyume_query->bindValue(':userID', $id);
    $kagoyume_query->bindValue(':total', $total[0]["total"] + $price);

    try {
        $kagoyume_query->execute();
    } catch (PDOException $e) {
        $kagoyume_db = null;
        return $e->getMessage();
    }

    $kagoyume_db = null;
    return null;
}