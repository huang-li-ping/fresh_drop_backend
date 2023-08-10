<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    $ordNo = $_POST["ordNo"];

    $sql = "select o.ord_date, o.ord_no, o.total_price, o.payment,  o.ord_cus, o.ord_phone, o.ord_addr
    c.cus_name,c.cus_email, 
    d.ord_status, d.week,
    d2.dishno,d2.qty,
    r.recipe_no,r.recipe_name

    from orders o
    left join customer c on o.cus_no = c.cus_no
    left join delivery d on o.ord_no = d.ord_no
    left join deliv_detail d2 on d.deliv_no = d2.deliv_no
    left join recipe r on d2.dishno = r.recipe_no
    where o.ord_no = :ordNo";
    
    $ordDetail = $pdo->prepare($sql);
    $ordDetail->bindValue(":ordNo", $ordNo);
    $ordDetail->execute();
    $orderRows = $ordDetail->fetchAll(PDO::FETCH_ASSOC);

    $orderDetail = array();
    $orderInfo = array("ord_date"=>$row["ord_date"],
                        "ord_no"=>$row["ord_no"],
                        "cus_name"=>$row["cus_name"],
                        "cus_email"=>$row["cus_email"],
                        "total_price"=>$row["total_price"],
                        "payment"=>$row["payment"],
                        "ord_status"=>$row["ord_status"],
                        "week"=>$row["week"],
                        "ord_cus"=>$row["ord_cus"],
                        "ord_phone"=>$row["ord_phone"],
                        "ord_addr"=>$row["ord_addr"],
                        "ord_phone"=>$row["ord_phone"],
                    );
    $orderDetail["orderInfo"] = $orderInfo;
    // 處理 orderList 資料
    $orderList = array();
    $orderDetail["orderList"] = $orderList;
    // 處理 billDetail 資料
    $billDetail = array("week"=>$row["week"],
                        "qty"=>$row["qty"],
                    );
    $orderDetail["billDetail"] = $billDetail;
    //訂單購買人收件人資料
    // $ordInfo = array("cus_name"=>$orderRows[0]["cus_name"],
    //                 "cus_email"=>$orderRows[0]["cus_email"],
    //                 "ord_phone"=>$orderRows[0]["ord_phone"],
    //                 "ord_addr"=>$orderRows[0]["ord_addr"]);
    $front4 = substr($ordInfo["ord_phone"],0,4);
    $back6 = substr($ordInfo["ord_phone"],4,6);
    $ordInfo["ord_phone"] = $front4. "-". $back6;
    
    $uniqueOrders = [];
    foreach ($orderRows as $row) {
        $ord_no = $row['ord_no'];
        if (!isset($uniqueOrders[$ord_no])) {
            $uniqueOrders[$ord_no] = $row;
        }
    }

    $uniqueOrderRows = array_values($uniqueOrders); 


    foreach ($uniqueOrderRows as &$row) {
        switch ($row['payment']) {
            case 0:
                $row['payment'] = 'ATM轉帳';
                break;
            case 1:
                $row['payment'] = '信用卡';
                break;
            case 2:
                $row['payment'] = '貨到付款';
                break;
            case 3:
                $row['payment'] = '禮物卡';
                break;
            default:
                $row['payment'] = '未知付款方式';
                break;
        }
        switch ($row['ord_status']) {
            case 0:
                $row['ord_status'] = '未處理';
                break;
            case 1:
                $row['ord_status'] = '處理中';
                break;
            case 2:
                $row['ord_status'] = '已出貨';
                break;
            case 3:
                $row['ord_status'] = '配送中';
                break;
            case 4:
                $row['ord_status'] = '已送達';
                break;
            case 5:
                $row['ord_status'] = '已取消';
                break;
            default:
                $row['ord_status'] = '未知訂單狀態';
                break;
        }
    }

    echo json_encode($orderDetail);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>