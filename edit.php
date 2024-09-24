<?php

/*******w******** 
    
    Name: Pamela Martin
    Date: September 16th, 2024
    Description:

****************/


require('authenticate.php');
require('connect.php');


if($_POST && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['id']) 
    && !empty($_POST['title']) && !empty($_POST['content'])){
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    if(isset($_POST['command']) && $_POST['command']== 'Delete'){
        $query = "DELETE FROM blog WHERE id = :id";
        $statement = $db-> prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $location = "index.php";
    } else {
        $query = "UPDATE blog SET title = :title, content = :content WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $location = "index.php";
    }

    $statement->execute();
    
    header("Location: {$location}");
    exit;
    
} else if(isset($_GET['id'])){

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM blog WHERE id = :id";

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();
    $blog = $statement->fetch();

} else {
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Edit this Post! &#127757</title>
</head>
<body>
    <header class="my-header">
        <div class="div-header">
            <img src=<?=$images[0]?> alt="Earth Logo">
            <h1>Blog</h1>
        </div>
    </header>
    <?php include('nav.php'); ?>

    <form method= "POST" action="edit.php">
        <div class="div_container">
            <h2 class="h2_form">Edit the post &#127757</h2>
            <div class="form-group">

                <input type="hidden" name="id" value="<?=$blog['id'] ?>">

                <label for="title">Title</label>
                <input id="title" name="title" value="<?=$blog['title'] ?>">
                
                <label for="content">Content</label>
                <textarea name="content" id="content" cols="30" rows="10" minlength="1"><?=$blog['content'] ?></textarea>   
            </div>
            <div class="div_buttons">
                <button type="submit" class="button" name="command" value="Update Blog"> Update Blog </button> 
                <button type="submit" class="button" name="command" value="Delete" onclick="return confirm('Are you sure you want to delete this post?')"> Delete Post </button>
            </div>
        </div>    
    </form>
    <?php include('footer.php'); ?>
</body>
</html>