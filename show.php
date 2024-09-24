<?php

/*******w******** 
    
    Name: Pamela Martin
    Date: September 16, 2024
    Description:

****************/
    require('connect.php');
   

    if(isset($_GET['id'])){
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM blog WHERE id = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();
        $blog = $statement->fetch();

    }
    else {
        $id = false;
    }
    $images = [
        'images/earthlogo.jpg',
        'images/earth.jpg'
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title><?= "{$blog['title']}" ?> - Blog</title>
</head>
<body>
    <header class="my-header">
        <div class="div-header">
            <img src=<?=$images[0]?> alt="Earth Logo">
            <h1>Blog</h1>
        </div>
    </header>

    <?php include('nav.php'); ?>
    <div class="div_container">
        <div class="index_posts">

            <h2><?=$blog['title'] ?></h2>
            <h4><?=date_format(date_create($blog['date_posted']), 'F j, Y G:i') ?></h4> 
            <?=$blog['content'] ?>

            <a href="edit.php?id=<?=$blog['id'] ?>">Edit</a>
        </div>

    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>