<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
$host = '127.0.0.1';
$db   = 'competools';
$user = 'root';
$pass = 'root';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);


$result =  $pdo->query('SELECT * FROM categories');
$categories = [];
while($row = $result->fetch()){

    $categories[$row['id']] = $row;
}




function getTree($dataset) {
    $tree = [];

    foreach ($dataset as $id => &$node) {    
            // Если нету вложений в колонке parent_id
        if (!$node['parent_id']){
            $tree[$id] = &$node;
        }else{ 
            //Если есть потомки то перебераем массив
            $dataset[$node['parent_id']]['childs'][$id] = &$node;
        }
    }
    return $tree;
}

$categoriesTree = getTree($categories);
echo '<pre>'. print_r($categoriesTree, true) . '</pre>';


?>






</body>
</html>


