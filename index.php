<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>
<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
<a href="create.php">Create New Post</a> | 
<a href="logout.php">Logout</a>
<a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>

<h3>All Posts</h3>
<table border="1">
<tr><th>Title</th><th>Content</th><th>Created</th><th>Action</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['content']; ?></td>
<td><?php echo $row['created_at']; ?></td>
<td>
  <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> | 
  <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>
