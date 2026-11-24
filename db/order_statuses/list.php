<?php
$base = "..";
require "../db.php";
require "../header.php";

$sql = "SELECT status_cd, status_name
        FROM order_statuses
        ORDER BY status_cd";
$stmt = db_query($sql);
?>

<h2>Order Statuses</h2>

<p><a href="insert.php" class="btn btn-success">+ Add</a></p>

<table>
    <tr>
        <th>status_cd</th>
        <th>status_name</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php while ($row = db_fetch($stmt)): ?>
    <tr>
        <td><?= htmlspecialchars($row['status_cd']) ?></td>
        <td><?= htmlspecialchars($row['status_name']) ?></td>
        <td><a href="edit.php?id=<?= htmlspecialchars($row['status_cd']) ?>" class="btn btn-warning">Edit</a></td>
        <td><a href="delete.php?id=<?= htmlspecialchars($row['status_cd']) ?>" class="btn btn-danger">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
