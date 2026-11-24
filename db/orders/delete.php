<?php
$base = "..";
require "../db.php";

$sqlDelete = "DELETE FROM orders WHERE order_id=?";
$sqlSelect = "SELECT order_id, customer_id, order_date, total_price, status_cd FROM orders WHERE order_id=?";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlDelete, [$_POST['order_id']]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Delete failed: " . $e->getMessage();
    }
}

$id = isset($_POST['order_id']) ? $_POST['order_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }

require "../header.php";
?>

<h2>Delete Order</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<p>Are you sure you want to delete this record?</p>

<table>
    <tr><th>order_id</th><td><?= htmlspecialchars($row['order_id']) ?></td></tr>
    <tr><th>customer_id</th><td><?= htmlspecialchars($row['customer_id']) ?></td></tr>
    <tr><th>order_date</th><td><?= htmlspecialchars($row['order_date']) ?></td></tr>
    <tr><th>total_price</th><td><?= htmlspecialchars($row['total_price']) ?></td></tr>
    <tr><th>status_cd</th><td><?= htmlspecialchars($row['status_cd']) ?></td></tr>
</table>

<form method="POST">
    <input type="hidden" name="order_id" value="<?= htmlspecialchars($row['order_id']) ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php sql_box($sqlDelete, $sqlSelect); ?>

<?php require "../footer.php"; ?>
