<?php
$base = "..";
require "../db.php";
require "../header.php";

$sql = "SELECT oi.order_item_id, oi.order_id, mi.item_name,
               oi.quantity, oi.unit_price
        FROM order_items oi
        LEFT JOIN menu_items mi ON oi.item_id = mi.item_id
        ORDER BY oi.order_item_id";
$stmt = db_query($sql);
?>

<h2>Order Items</h2>

<p><a href="insert.php" class="btn btn-success">+ Add</a></p>

<table>
    <tr>
        <th>order_item_id</th>
        <th>order_id</th>
        <th>item_name</th>
        <th>quantity</th>
        <th>unit_price</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php while ($row = db_fetch($stmt)): ?>
    <tr>
        <td><?= htmlspecialchars($row['order_item_id']) ?></td>
        <td><?= htmlspecialchars($row['order_id']) ?></td>
        <td><?= htmlspecialchars($row['item_name']) ?></td>
        <td><?= htmlspecialchars($row['quantity']) ?></td>
        <td><?= htmlspecialchars($row['unit_price']) ?></td>
        <td><a href="edit.php?id=<?= htmlspecialchars($row['order_item_id']) ?>" class="btn btn-warning">Edit</a></td>
        <td><a href="delete.php?id=<?= htmlspecialchars($row['order_item_id']) ?>" class="btn btn-danger">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
