<?php
header('Access-Control-Allow-Origin:*');


try {
    require_once("connect_chd102g2.php");
    // var_dump($pdo);

    $ordNo = $_POST["ordNo"];
    // $ordNo = "4";

    $sql = "select o.ord_date, o.ord_no, o.ord_price, o.discount_price, o.total_price, o.payment,  o.ord_cus, o.ord_phone, o.ord_addr,
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
    if (!empty($orderRows)) {
        $orderInfo = array(
            "ord_date" => $orderRows[0]["ord_date"],
            "ord_no" => $orderRows[0]["ord_no"],
            "cus_name" => $orderRows[0]["cus_name"],
            "cus_email" => $orderRows[0]["cus_email"],
            "ord_price" => $orderRows[0]["ord_price"],
            "discount_price" => $orderRows[0]["discount_price"],
            "total_price" => $orderRows[0]["total_price"],
            "payment" => $orderRows[0]["payment"],
            "ord_status" => $orderRows[0]["ord_status"],
            "week" => $orderRows[0]["week"],
            "ord_cus" => $orderRows[0]["ord_cus"],
            "ord_phone" => $orderRows[0]["ord_phone"],
            "ord_addr" => $orderRows[0]["ord_addr"],
        );
        $orderDetail["orderInfo"] = $orderInfo;

        // 處理 orderList 資料
        $orderList = array();
        $weekAdded = array();
        foreach ($orderRows as $row) {
            $week = array();
            if (!in_array($row["week"], $weekAdded)) {
                foreach ($orderRows as $row2) {
                    $dish = array(
                        "recipe" => $row2["recipe_name"],
                        "qty" => $row2["qty"],
                        "status" => $row2["ord_status"]
                    );
                    if ($row["week"] == $row2["week"]) {
                        $week[] = $dish;
                    }
                }
                $orderList[] = $week;
                $weekAdded[] = $row["week"];
            }

        }
        $orderDetail["orderList"] = $orderList;

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
        // var_dump($orderDetail);
        // exit();
        echo json_encode($orderDetail);
    }
} catch (Exception $e) {
    var_dump($e->getMessage());
    echo json_encode(["連線失敗"]);
}
?>