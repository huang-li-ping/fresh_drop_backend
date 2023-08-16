<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');


try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $file = $_FILES["image"];
        $dir = __DIR__ . "/../gift_images/";
        //$dir = "images/"; //存放的路徑
        if (file_exists($dir) === false) {
            mkdir($dir);
        }

        $from = $_FILES["image"]["tmp_name"];
        $fileName = uniqid();
        $fileExt = pathInfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $fileName = "$fileName.$fileExt";
        $to = $dir . $fileName;
        copy($from, $to);
        // echo $to;

        $fileNameOnly = basename($to);
        echo $fileNameOnly;   //只傳檔名
    }
} catch (Exception $e) {
    echo json_encode(["error" => "連線失敗：" . $e->getMessage()]);
}

    ?>