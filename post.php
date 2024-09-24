<?php

/*******w******** 
    
    Name: Pamela Martin
    Date: September 16, 2024
    Description:

****************/

    require('connect.php');
    require('authenticate.php');

    if($_POST && !empty($_POST['title']) && !empty($_POST['content'])){
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    

        $query = "INSERT INTO blog (title, content) VALUES (:title, :content)";
        $statement = $db-> prepare($query);

        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
    

        if($statement->execute()) {
            echo "Success";
        }

        header("Location: index.php?{$id}");
        exit;
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>My Blog Post! &#127757</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <header class="my-header">
        <div class="div-header">
            <img src=<?=$images[0]?> alt="Earth Logo">
            <h1>Blog</h1>
        </div>
    </header>
    <?php include('nav.php'); ?>
    <form method= "POST" action="post.php">
        <div class="div_container">
            <h2 class="h2_form">New Post &#127757</h2>
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" name="title">
                <label for="content">Content</label>
                <textarea name="content" id="content" cols="30" rows="10" minlength="1"></textarea>   
            </div>
            <div class="div_buttons">
                <button type="submit" class="button-primary"> Submit Blog </button> 
            </div>
            
        </div>
    </form>
    <?php include('footer.php'); ?>
</body>
</html>