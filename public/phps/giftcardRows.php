<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    $sql = "select giftcard_pic_no, giftcard_pic_name, giftcard_pic_type, giftcard_defaultpic_url, giftcard_pic_date, giftcard_pic_status
            from giftcard_pic";
    $giftcard = $pdo->query($sql);
    $giftcardRows = $giftcard->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode(["連線成功"]);
    echo json_encode($giftcardRows);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>