<?php
$base = "..";
require "../db.php";
require "../header.php";

$sql = "SELECT category_cd, category_name
        FROM categories
        ORDER BY category_cd";
$stmt = db_query($sql);
?>

<h2>Categories</h2>

<p><a href="insert.php" class="btn btn-success">+ Add</a></p>

<table>
    <tr>
        <th>category_cd</th>
        <th>category_name</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php while ($row = db_fetch($stmt)): ?>
    <tr>
        <td><?= htmlspecialchars($row['category_cd']) ?></td>
        <td><?= htmlspecialchars($row['category_name']) ?></td>
        <td><a href="edit.php?id=<?= htmlspecialchars($row['category_cd']) ?>" class="btn btn-warning">Edit</a></td>
        <td><a href="delete.php?id=<?= htmlspecialchars($row['category_cd']) ?>" class="btn btn-danger">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
