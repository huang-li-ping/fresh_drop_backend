<?php
header('Access-Control-Allow-Origin: *');


try {
    require_once("connect_chd102g2.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $giftcard_pic_no = $_POST['giftcard_pic_no'];
        $giftcard_pic_name = $_POST['giftcard_pic_name'];
        $giftcard_pic_type = $_POST['giftcard_pic_type'];
        $giftcard_defaultpic_url = $_POST['giftcard_defaultpic_url'];
        $giftcard_pic_date = $_POST['giftcard_pic_date'];
        $giftcard_pic_status = $_POST['giftcard_pic_status'];
        echo $_POST['submit'];

        // 新增or修改or刪除
    }
    if (isset($_POST['submit']) && $_POST['submit'] == '新增') {
        // 執行新增
        $sql = "INSERT INTO giftcard_pic (giftcard_pic_no, giftcard_pic_name, giftcard_pic_type, giftcard_defaultpic_url, giftcard_pic_date, giftcard_pic_status) 
                    VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$giftcard_pic_no, $giftcard_pic_name, $giftcard_pic_type, $giftcard_defaultpic_url, $giftcard_pic_date, $giftcard_pic_status]);
        echo json_encode(["message" => "create successfully"]);
    } elseif (isset($_POST['submit']) && $_POST['submit'] == '存檔') {
        // 執行修改
        $sql = "UPDATE giftcard_pic 
            SET giftcard_pic_name = ?, giftcard_pic_type= ?, giftcard_defaultpic_url = ?, giftcard_pic_date = ? , giftcard_pic_status =?
            WHERE giftcard_pic_no = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$giftcard_pic_name, $giftcard_pic_type, $giftcard_defaultpic_url, $giftcard_pic_date, $giftcard_pic_status, $giftcard_pic_no]);

        echo json_encode(["message" => "update successfully"]);
    } elseif (isset($_POST['submit']) && $_POST['submit'] == '刪除') {
        // 執行刪除
        $sql = "DELETE FROM giftcard_pic WHERE giftcard_pic_no = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$giftcard_pic_no]);
        echo json_encode(["message" => "delete successfully"]);

    } else {
        echo json_encode(["error" => "fail"]);
    }


} catch (Exception $e) {
    echo json_encode(["error" => "連線失敗：" . $e->getMessage()]);
}

var_dump($_POST)

    ?>