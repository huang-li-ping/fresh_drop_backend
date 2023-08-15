<?php
header('Access-Control-Allow-Origin: *');

try {
    require_once("connect_chd102g2.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $result_no = $_POST['result_no'];
        $status = $_POST['status'];
        $personality = $_POST['personality'];
        $dish1 = $_POST['dish1'];
        $dish2 = $_POST['dish2'];
        $dish3 = $_POST['dish3'];
        $dish4 = $_POST['dish4'];
        $content = $_POST['content'];
        $submit = $_POST['submit']; // Capture the value of the submit button

        // Check the value of the submit button
        if ($submit == '新增') {
            // 執行新增
            echo "執行新增";
            $sql = "INSERT INTO game (result_no, `status`, personality, dish1, dish2, dish3, dish4, content) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$result_no, $status, $personality, $dish1, $dish2, $dish3, $dish4, $content]);
            echo json_encode(["message" => "create successfully"]);
        } elseif ($submit == '存檔') {
            // 執行修改
            $sql = "UPDATE game 
                    SET `status` = ?, personality = ?, dish1= ?, dish2 = ?, dish3 = ?, dish4 = ?, content = ?
                    WHERE result_no = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$status, $personality, $dish1, $dish2, $dish3, $dish4, $content, $result_no]);
            echo json_encode(["message" => "update successfully"]);
        } elseif ($submit == '刪除') {
            // 執行刪除
            $sql = "DELETE FROM game WHERE result_no = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$result_no]);
            echo json_encode(["message" => "delete successfully"]);
        } else {
            echo json_encode(["error" => "fail"]);
        }
    }
} catch (Exception $e) {
    echo json_encode(["error" => "連線失敗failed"]);
}

var_dump($_POST);
