<?php
$base = "..";
require "../db.php";

$sqlDelete = "DELETE FROM order_statuses WHERE status_cd=?";
$sqlSelect = "SELECT status_cd, status_name FROM order_statuses WHERE status_cd=?";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlDelete, [$_POST['status_cd']]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Delete failed: " . $e->getMessage();
    }
}

$id = isset($_POST['status_cd']) ? $_POST['status_cd'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }

require "../header.php";
?>

<h2>Delete Order Status</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<p>Are you sure you want to delete this record?</p>

<table>
    <tr><th>status_cd</th><td><?= htmlspecialchars($row['status_cd']) ?></td></tr>
    <tr><th>status_name</th><td><?= htmlspecialchars($row['status_name']) ?></td></tr>
</table>

<form method="POST">
    <input type="hidden" name="status_cd" value="<?= htmlspecialchars($row['status_cd']) ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php sql_box($sqlDelete, $sqlSelect); ?>

<?php require "../footer.php"; ?>
