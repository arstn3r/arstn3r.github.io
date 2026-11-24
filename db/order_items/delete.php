<?php
$base = "..";
require "../db.php";

$sqlDelete = "DELETE FROM order_items WHERE order_item_id=?";
$sqlSelect = "SELECT order_item_id, order_id, item_id, quantity, unit_price FROM order_items WHERE order_item_id=?";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlDelete, [$_POST['order_item_id']]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Delete failed: " . $e->getMessage();
    }
}

$id = isset($_POST['order_item_id']) ? $_POST['order_item_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }

require "../header.php";
?>

<h2>Delete Order Item</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<p>Are you sure you want to delete this record?</p>

<table>
    <tr><th>order_item_id</th><td><?= htmlspecialchars($row['order_item_id']) ?></td></tr>
    <tr><th>order_id</th><td><?= htmlspecialchars($row['order_id']) ?></td></tr>
    <tr><th>item_id</th><td><?= htmlspecialchars($row['item_id']) ?></td></tr>
    <tr><th>quantity</th><td><?= htmlspecialchars($row['quantity']) ?></td></tr>
    <tr><th>unit_price</th><td><?= htmlspecialchars($row['unit_price']) ?></td></tr>
</table>

<form method="POST">
    <input type="hidden" name="order_item_id" value="<?= htmlspecialchars($row['order_item_id']) ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php sql_box($sqlDelete, $sqlSelect); ?>

<?php require "../footer.php"; ?>
