<?php
require 'classes/Database.php';
$database = new Database;
$database->query('SELECT * FROM posts');
$rows = $database->resultSet();
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(isset($_POST['submit'])){
    $title = $post['title'];
    $body = $post['body'];
    $database->query('INSERT INTO posts (title,body) VALUES (:title, :body)');
    $database->bind(':title',$title);   
    $database->bind(':body',$body);   
    $database->execute();
    if($database->lastInsertId()){
        echo '<p> Post Added</p>';
    }
    //header("Refresh:0");

    $database->query('SELECT * FROM posts');
    $rows = $database->resultSet();
}
if(isset($_POST['update'])){
    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];
    $database->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
    $database->bind(':title',$title);
    $database->bind(':body',$body);
    $database->bind(':id',$id);
    $database->execute();
    if($database->lastInsertId()){
        echo '<p> Post Added</p>';
    }
    //header("Refresh:0");

    $database->query('SELECT * FROM posts');
    $rows = $database->resultSet();
}
if(isset($_POST['delete'])){
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM posts WHERE id = :id');
    $database->bind(':id',$delete_id);
    $database->execute();
    $database->query('SELECT * FROM posts');
    $rows = $database->resultSet();

}

?>
<h1>Add post</h1>
<form method = "post" action="<?php $_SERVER['PHP_SELF'];?>">
<label for="title">Post title</label>
<input type="text" name="id" id="title" placeholder = 'Add title..' required>
<label for="body">Post body</label>
<textarea name="body" id="body" required></textarea>
<input type="submit" name="submit" value="Submit">
</form>
<h1>Update post</h1>
<form method = "post" action="<?php $_SERVER['PHP_SELF'];?>">
    <label for="id">Post id</label>
    <input type="number" name="id" id="id" placeholder = 'Add Id..' required>
    <label for="title">Post title</label>
    <input type="text" name="title" id="title" placeholder = 'Add title..' required>
    <label for="body">Post body</label>
    <textarea name="body" id="body" required></textarea>
    <input type="submit" name="update" value="Update..">
</form>

<h1>posts</h1>
<div>
<?php foreach ($rows as $row) : ?>
<div>
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['body']; ?></p>
    <br>
    <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
        <input type="submit" name="delete" value="Delete">

    </form>
</div>

<?php endforeach; ?>
</div>