<?php
$base = "..";
require "../db.php";
require "../header.php";

$sql = "SELECT mi.item_id, mi.item_name, mi.description, mi.price,
               c.category_name, mi.is_available
        FROM menu_items mi
        LEFT JOIN categories c ON mi.category_cd = c.category_cd
        ORDER BY mi.item_id";
$stmt = db_query($sql);
?>

<h2>Menu Items</h2>

<p><a href="insert.php" class="btn btn-success">+ Add</a></p>

<table>
    <tr>
        <th>item_id</th>
        <th>item_name</th>
        <th>description</th>
        <th>price</th>
        <th>category_name</th>
        <th>is_available</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php while ($row = db_fetch($stmt)): ?>
    <tr>
        <td><?= htmlspecialchars($row['item_id']) ?></td>
        <td><?= htmlspecialchars($row['item_name']) ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td><?= htmlspecialchars($row['price']) ?></td>
        <td><?= htmlspecialchars($row['category_name']) ?></td>
        <td><?= htmlspecialchars($row['is_available']) ?></td>
        <td><a href="edit.php?id=<?= htmlspecialchars($row['item_id']) ?>" class="btn btn-warning">Edit</a></td>
        <td><a href="delete.php?id=<?= htmlspecialchars($row['item_id']) ?>" class="btn btn-danger">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
