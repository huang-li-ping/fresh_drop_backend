<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    $sql = "select recipe_no, recipe_name, step, state, des, recipe_pic, class
            from recipe";
    
    // $sql = "SELECT
    // r.recipe_no, r.recipe_name, r.step, r.state, r.des, r.recipe_pic, r.class,
    // i.ingred_no, i.ingred_name,
    // d.ingred_quantity
    // FROM
    // dishes d
    // INNER JOIN
    // recipe r ON d.recipe_no = r.recipe_no
    // INNER JOIN
    // ingred i ON d.ingred_no = i.ingred_no";

    $recipe = $pdo->query($sql);
    $recipeRows = $recipe->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode(["連線成功"]);
    echo json_encode($recipeRows);
}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>
