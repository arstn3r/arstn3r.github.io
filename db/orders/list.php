<?php
$base = "..";
require "../db.php";
require "../header.php";

$sql = "SELECT o.order_id, c.customer_name, o.order_date, o.total_price,
               os.status_name
        FROM orders o
        LEFT JOIN customers c ON o.customer_id = c.customer_id
        LEFT JOIN order_statuses os ON o.status_cd = os.status_cd
        ORDER BY o.order_id";
$stmt = db_query($sql);
?>

<h2>Orders</h2>

<p><a href="insert.php" class="btn btn-success">+ Add</a></p>

<table>
    <tr>
        <th>order_id</th>
        <th>customer_name</th>
        <th>order_date</th>
        <th>total_price</th>
        <th>status_name</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php while ($row = db_fetch($stmt)): ?>
    <tr>
        <td><?= htmlspecialchars($row['order_id']) ?></td>
        <td><?= htmlspecialchars($row['customer_name']) ?></td>
        <td><?= htmlspecialchars($row['order_date']) ?></td>
        <td><?= htmlspecialchars($row['total_price']) ?></td>
        <td><?= htmlspecialchars($row['status_name']) ?></td>
        <td><a href="edit.php?id=<?= htmlspecialchars($row['order_id']) ?>" class="btn btn-warning">Edit</a></td>
        <td><a href="delete.php?id=<?= htmlspecialchars($row['order_id']) ?>" class="btn btn-danger">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
