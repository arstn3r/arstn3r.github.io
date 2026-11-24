<?php
$base = "..";
require "../db.php";
require "../header.php";

$sql = "SELECT r.review_id, c.customer_name, mi.item_name,
               r.star_rating, r.review_date
        FROM reviews r
        LEFT JOIN customers c ON r.customer_id = c.customer_id
        LEFT JOIN menu_items mi ON r.item_id = mi.item_id
        ORDER BY r.review_id";
$stmt = db_query($sql);
?>

<h2>Reviews</h2>

<p><a href="insert.php" class="btn btn-success">+ Add</a></p>

<table>
    <tr>
        <th>review_id</th>
        <th>customer_name</th>
        <th>item_name</th>
        <th>star_rating</th>
        <th>review_date</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php while ($row = db_fetch($stmt)): ?>
    <tr>
        <td><?= htmlspecialchars($row['review_id']) ?></td>
        <td><?= htmlspecialchars($row['customer_name']) ?></td>
        <td><?= htmlspecialchars($row['item_name']) ?></td>
        <td><?= htmlspecialchars($row['star_rating']) ?></td>
        <td><?= htmlspecialchars($row['review_date']) ?></td>
        <td><a href="edit.php?id=<?= htmlspecialchars($row['review_id']) ?>" class="btn btn-warning">Edit</a></td>
        <td><a href="delete.php?id=<?= htmlspecialchars($row['review_id']) ?>" class="btn btn-danger">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
