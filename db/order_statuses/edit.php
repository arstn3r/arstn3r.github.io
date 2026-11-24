<?php
$base = "..";
require "../db.php";

$sqlUpdate = "UPDATE order_statuses SET status_name=? WHERE status_cd=?";
$sqlSelect = "SELECT status_cd, status_name FROM order_statuses WHERE status_cd=?";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlUpdate, [
            $_POST['status_name'],
            $_POST['status_cd']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}

$id = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST['status_cd'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }
$vals = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $row;

require "../header.php";
?>

<h2>Edit Order Status</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>status_cd</label>
        <input type="text" name="status_cd" value="<?= htmlspecialchars($row['status_cd']) ?>" readonly>

        <label>status_name</label>
        <input type="text" name="status_name" value="<?= htmlspecialchars($vals['status_name']) ?>" required>

        <br><br>
        <button type="submit" class="btn btn-warning">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sqlUpdate, $sqlSelect); ?>

<?php require "../footer.php"; ?>
