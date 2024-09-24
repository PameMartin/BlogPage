<?php

/*******w******** 
    
    Name: Pamela Martin
    Date: September 16th, 2024
    Description:

****************/

    require('connect.php');

    $query = "SELECT * FROM blog ORDER BY date_posted DESC LIMIT 5";

    $statement = $db->prepare($query);

    $statement->execute();
    $images = [
        'images/earthlogo.jpg',
        'images/earth.jpg'
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to my Blog! &#127757</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <header class="my-header">
        <div class="div-header">
            <img src="<?=$images[0]?>" alt="Earth Logo">
            <h1>Blog</h1>
        </div>
    </header>

    <?php include('nav.php'); ?>

    <div class="div_container">
        <h2>Recently posted blog entries &#127757</h2>
        
        <?php if($statement->rowCount() == 0) : ?>
            <p>No blog entries yet!</p>
            <a href="post.php"> +New Blog</a>    
        <?php endif; ?>

        <div class="index_posts">
            <?php while($row = $statement-> fetch()): ?>
                <a href="show.php?id=<?=$row['id']?>"><?=$row['title'] ?></a>

                <div class="content_title">
                    <h4><?=date_format(date_create($row['date_posted']), 'F j, Y G:i') ?></h4>
                    <a href="edit.php?id=<?=$row['id'] ?>">Edit</a> 
                </div>
                
                <div class="content">
                    <?php if(strlen($row['content']) > 200) : ?>
                    <?=substr($row['content'], 0, 200) ?>
                    ... <a href="show.php?id=<?=$row['id'] ?>">Read More</a>
                    
                    <?php else: ?>
                        <?=$row['content'] ?>
                    <?php endif ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>