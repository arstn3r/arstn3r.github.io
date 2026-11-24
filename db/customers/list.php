<?php
$base = "..";
require "../db.php";
require "../header.php";

$sql = "SELECT customer_id, customer_name, email, password_hash, phone, is_active
        FROM customers
        ORDER BY customer_id";
$stmt = db_query($sql);
?>

<h2>Customers</h2>

<p><a href="insert.php" class="btn btn-success">+ Add</a></p>

<table>
    <tr>
        <th>customer_id</th>
        <th>customer_name</th>
        <th>email</th>
        <th>password_hash</th>
        <th>phone</th>
        <th>is_active</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php while ($row = db_fetch($stmt)): ?>
    <tr>
        <td><?= htmlspecialchars($row['customer_id']) ?></td>
        <td><?= htmlspecialchars($row['customer_name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['password_hash']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['is_active']) ?></td>
        <td><a href="edit.php?id=<?= htmlspecialchars($row['customer_id']) ?>" class="btn btn-warning">Edit</a></td>
        <td><a href="delete.php?id=<?= htmlspecialchars($row['customer_id']) ?>" class="btn btn-danger">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
