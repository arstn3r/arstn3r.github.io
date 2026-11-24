<?php
$base = "..";
require "../db.php";
require "../header.php";

$sql = "SELECT admin_id, username, password_hash
        FROM admins
        ORDER BY admin_id";
$stmt = db_query($sql);
?>

<h2>Admins</h2>

<p><a href="insert.php" class="btn btn-success">+ Add</a></p>

<table>
    <tr>
        <th>admin_id</th>
        <th>username</th>
        <th>password_hash</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php while ($row = db_fetch($stmt)): ?>
    <tr>
        <td><?= htmlspecialchars($row['admin_id']) ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['password_hash']) ?></td>
        <td><a href="edit.php?id=<?= htmlspecialchars($row['admin_id']) ?>" class="btn btn-warning">Edit</a></td>
        <td><a href="delete.php?id=<?= htmlspecialchars($row['admin_id']) ?>" class="btn btn-danger">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
