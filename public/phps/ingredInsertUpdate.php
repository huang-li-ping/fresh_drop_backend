<?php
header('Access-Control-Allow-Origin: *');

try {
    require_once("connect_chd102g2.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ingred_no = $_POST['ingred_no'];
        $ingred_name = $_POST['ingred_name'];
        $allergy = $_POST['allergy'];
        $dislike = $_POST['dislike'];
        $submit = $_POST['submit']; // Capture the value of the submit button

        // Check the value of the submit button
        if ($submit == '新增') {
            // 執行新增
            echo "執行新增";
            $sql = "INSERT INTO ingred (ingred_no, `ingred_name`, allergy, dislike) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$ingred_no, $ingred_name, $allergy, $dislike]);
            echo json_encode(["message" => "create successfully"]);
        } elseif ($submit == '存檔') {
            // 執行修改
            $sql = "UPDATE ingred 
                    SET `ingred_name` = ?, allergy = ?, dislike = ? 
                    WHERE ingred_no = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$ingred_name, $allergy, $dislike, $ingred_no]);
            echo json_encode(["message" => "update successfully"]);
        } elseif ($submit == '刪除') {
            // 執行刪除
            $sql = "DELETE FROM ingred WHERE ingred_no = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$ingred_no]);
            echo json_encode(["message" => "delete successfully"]);
        } else {
            echo json_encode(["error" => "fail"]);
        }
    }
} catch (Exception $e) {
    echo json_encode(["error" => "連線失敗failed"]);
}

var_dump($_POST);
