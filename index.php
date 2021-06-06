<?php
require 'classes/Database.php';
$database = new Database;
$database->query('SELECT * FROM posts');
$rows = $database->resultSet();

?>
<h1>posts</h1>
<div>
<?php foreach ($rows as $row) : ?>
<div>
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['body']; ?></p>
</div>

<?php endforeach; ?>
</div>