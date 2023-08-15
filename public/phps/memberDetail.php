<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    $cusNo = $_POST["cusNo"];
    // $cusNo = 1;

    $sql = "select c.cus_no, c.cus_name, c.cus_email, c.phone, c.birth, c.address,
                    o.ord_date, o.ord_no, d.ord_status,
                    g.giftcard_no, g.giftcard_balance, g.giftcard_purchase_date,
                    c2.cus_name as 'giver_name'
            from customer c left join orders o on c.cus_no=o.cus_no
                            left join delivery d on o.ord_no=d.ord_no
                            left join giftcard g on c.cus_no=g.owner
                            left join customer c2 on c2.cus_no=g.giver
            where c.cus_no=:cusNo
            order by g.giftcard_purchase_date desc,o.ord_no desc";
    
    $memDetail = $pdo->prepare($sql);
    $memDetail->bindValue(":cusNo", $cusNo);
    $memDetail->execute();

    $detailRows = $memDetail->fetchAll(PDO::FETCH_ASSOC);
    //會員資料
    $memInfo = array("cus_no" => $detailRows[0]["cus_no"], 
                    "cus_name"=>$detailRows[0]["cus_name"],
                    "cus_email"=>$detailRows[0]["cus_email"],
                    "phone"=>$detailRows[0]["phone"],
                    "birth"=>$detailRows[0]["birth"],
                    "address"=>$detailRows[0]["address"]);
    
    //整理禮物卡資料
    $originLen = count($detailRows);
    $giftcardRows = array();
    $giftAdded = array();
    if ($detailRows[0]["giftcard_no"] !== null) {
        foreach ($detailRows as $index => $item) {
            $giftcardItem = array(
                "cus_no"=>$item["cus_no"],
                "giftcard_no"=>$item["giftcard_no"],
                "giver_name"=>$item["giver_name"], 
                "giftcard_balance"=>$item["giftcard_balance"], 
                "giftcard_purchase_date"=>$item["giftcard_purchase_date"]
            );
            if ($item["cus_name"] == $item["giver_name"]) {
                $giftcardItem["giver_name"] = "自己";
            }
            if (!in_array($item["giftcard_no"], $giftAdded)) {
                array_push($giftcardRows, $giftcardItem);
                array_push($giftAdded,$item["giftcard_no"]);
            }
        }
    }

    // var_dump($giftcardRows);
    // exit();
    //整理訂單資料
    #有未完成的week就整單呈現"未完成"
    $shopHistory = array();
    if ($detailRows[0]["ord_no"] !== null) {
        foreach ($detailRows as $item) {
            $historyItem = array("ord_no"=>$item["ord_no"],"ord_date"=>$item["ord_date"],"ord_status"=>$item["ord_status"]);
            $index = -1;
            #如果$shopHistory已經有"ord_no"，$index就會>=0
            foreach ($shopHistory as $key=>$newItem) {
                if ($newItem["ord_no"] == $historyItem["ord_no"]) {
                    $index = $key;
                }
    
            }
            if ($index >= 0 && $historyItem["ord_status"] != "3") {
                if ($historyItem["ord_status"] == "4") {
                    $shopHistory[$index]["ord_status"] = "已取消";
                } else {
                    $shopHistory[$index]["ord_status"] = "未完成";
                }
            }else if($index < 0){
                if($historyItem["ord_status"] != "3"){
                    if ($historyItem["ord_status"] == "4") {
                        $historyItem["ord_status"] = "已取消";
                    } else {
                        $historyItem["ord_status"] = "未完成";
                    
                    }
                } else {
                    $historyItem["ord_status"] = "已完成";
                }
                $shopHistory[] = $historyItem;
            }
        }
    
    }
    echo json_encode([$memInfo, $shopHistory,$giftcardRows]);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>