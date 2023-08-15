<?php
header('Access-Control-Allow-Origin:*');

try {
    require_once("connect_chd102g2.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $opinion_no = $_POST['opinion_no'];

        // 执行删除操作
        $sql = "DELETE FROM opinion WHERE opinion_no = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$opinion_no]);
        
        echo json_encode(["message" => "Delete operation completed successfully"]);
    }
} catch(Exception $e) {
    echo json_encode(["error" => "Operation failed"]);
}
?>