<?php
$base = "..";
require "../db.php";

$sqlDelete = "DELETE FROM customers WHERE customer_id=?";
$sqlSelect = "SELECT customer_id, customer_name, email, phone, is_active FROM customers WHERE customer_id=?";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlDelete, [$_POST['customer_id']]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Delete failed: " . $e->getMessage();
    }
}

$id = isset($_POST['customer_id']) ? $_POST['customer_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }

require "../header.php";
?>

<h2>Delete Customer</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<p>Are you sure you want to delete this record?</p>

<table>
    <tr><th>customer_id</th><td><?= htmlspecialchars($row['customer_id']) ?></td></tr>
    <tr><th>customer_name</th><td><?= htmlspecialchars($row['customer_name']) ?></td></tr>
    <tr><th>email</th><td><?= htmlspecialchars($row['email']) ?></td></tr>
    <tr><th>phone</th><td><?= htmlspecialchars($row['phone']) ?></td></tr>
    <tr><th>is_active</th><td><?= htmlspecialchars($row['is_active']) ?></td></tr>
</table>

<form method="POST">
    <input type="hidden" name="customer_id" value="<?= htmlspecialchars($row['customer_id']) ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php sql_box($sqlDelete, $sqlSelect); ?>

<?php require "../footer.php"; ?>
