<?php
header('Access-Control-Allow-Origin:*');

try{
    require_once("connect_chd102g2.php");

    $sql = "SELECT
    r.recipe_no, r.recipe_name,
    r.step, r.state, r.des, r.recipe_pic, r.class,
    i.ingred_no, i.ingred_name, d.quantity_unit
    FROM
    dishes d
    INNER JOIN
    ingred i ON d.ingred_no = i.ingred_no
    INNER JOIN
    recipe r ON d.recipe_no = r.recipe_no";

    $recipe = $pdo->query($sql);
    $recipeRows = $recipe->fetchAll(PDO::FETCH_ASSOC);

    $newRecipeArr = array();
    $ingredAdded = array();
    foreach($recipeRows as $index => $item){
        $dish = array(
            "recipe_no"=>$item["recipe_no"],
            "recipe_name"=>$item["recipe_name"],
            "step"=>$item["step"],
            "state"=>$item["state"],
            "des"=>$item["des"],
            "recipe_pic"=>$item["recipe_pic"],
            "class"=>$item["class"],
            "ingreds"=>array()
        );

        $ingredsArr = array();
        foreach($recipeRows as $index2 => $item2){
            if($item2["recipe_no"] === $item["recipe_no"]){
                $ingred = array(
                    "ingred_no"=>$item2["ingred_no"],
                    "ingred_name"=>$item2["ingred_name"],
                    "quantity_unit"=>$item2["quantity_unit"],
                );
                array_push($dish["ingreds"], $ingred);
            }
        }

        if(!in_array( $item["recipe_no"],$ingredAdded)){
            array_push($ingredAdded, $dish["recipe_no"]);
            array_push($newRecipeArr, $dish);
        }

        foreach ($recipeRows as &$row) {
            switch ($row['class']) {
                case 0:
                    $row['class'] = '主菜';
                    break;
                case 1:
                    $row['class'] = '湯品';
                    break;
                case 2:
                    $row['class'] = '沙拉';
                    break;
            }
        }
    }



    // var_dump($newRecipeArr);
    // echo json_encode(["連線成功"]);
    echo json_encode($newRecipeArr);

}catch(Exception $e){
    echo json_encode(["連線失敗"]);
}
?>
