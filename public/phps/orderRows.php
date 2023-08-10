<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    $sql = "select o.ord_date, o.ord_no, c.cus_name,c.cus_email, o.total_price, o.payment, d.ord_status
    from orders o
    join customer c on o.cus_no = c.cus_no
    join delivery d on o.ord_no = d.ord_no
    order by o.ord_no desc";
    
    $order = $pdo->query($sql);
    $orderRows = $order->fetchAll(PDO::FETCH_ASSOC);
    
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

    echo json_encode($uniqueOrderRows);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>