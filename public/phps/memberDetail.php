<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    // $cusNo = $_POST["cusNo"];
    $cusNo = 1;

    $sql = "select c.cus_no, c.cus_name, c.cus_email, c.phone, c.birth,
                    o.ord_date, o.ord_no, d.ord_status,
                    g.giftcard_no, g.giver, g.giftcard_balance
            from customer c join orders o on c.cus_no=o.cus_no
                            join delivery d on o.ord_no=d.ord_no
                            join giftcard g on c.cus_no=g.owner
            where c.cus_no=:cusNo";
    $memDetail = $pdo->prepare($sql);
    $memDetail->bindValue(":cusNo", $cusNo);
    $memDetail->execute();

    $detailRows = $memDetail->fetchAll(PDO::FETCH_ASSOC);
    $memInfo = array("cus_no" => $detailRows[0]["cus_no"], 
                    "cus_name"=>$detailRows[0]["cus_name"],
                    "cus_email"=>$detailRows[0]["cus_email"],
                    "phone"=>$detailRows[0]["phone"],
                    "birth"=>$detailRows[0]["birth"]);
    //整理禮物卡資料
    $originLen = count($detailRows);
    $giftcardRows = array();
    foreach ($detailRows as $index => $item) {
        $giftcardItem = array("cus_no"=>$item["cus_no"],"giftcard_no"=>$item["giftcard_no"],"giver"=>$item["giver"], "giftcard_balance"=>$item["giftcard_balance"]);
        if ($index == $GLOBALS['originLen']-1) {
            array_push($giftcardRows, $giftcardItem);
        }else if ($item["giftcard_no"] !== $detailRows[$index + 1]["giftcard_no"]) {
            array_push($giftcardRows, $giftcardItem);
        }
    };
    //整理訂單資料
    #有未完成的week就整單呈現"未完成"
    $shopHistory = array();
    foreach ($detailRows as $index => $item) {
        $historyItem = array("ord_no"=>$item["ord_no"],"ord_date"=>$item["ord_date"],"ord_status"=>$item["ord_status"]);

        if($item["ord_no"] !== $detailRows[$index + 1]["ord_no"]){
            array_push($shopHistory, $historyItem);
        }
    }
    var_dump($detailRows);
    // echo json_encode(["連線成功"]);
    // echo json_encode($detailRows);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>