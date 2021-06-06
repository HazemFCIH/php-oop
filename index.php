<?php
require 'classes/Database.php';
$database = new Database;
$database->query('SELECT * FROM posts');
$rows = $database->resultSet();
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
IF(isset($_POST['submit'])){
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

?>
<h1>Add post</h1>
<form method = "post" action="<?php $_SERVER['PHP_SELF'];?>">
<label for="title">Post title</label>
<input type="text" name="title" id="title" placeholder = 'Add title..' required>
<label for="body">Post body</label>
<textarea name="body" id="body" required></textarea>
<input type="submit" name="submit" value="Submit">
</form>

<h1>posts</h1>
<div>
<?php foreach ($rows as $row) : ?>
<div>
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['body']; ?></p>
</div>

<?php endforeach; ?>
</div>