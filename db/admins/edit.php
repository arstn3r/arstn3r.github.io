<?php
$base = "..";
require "../db.php";

$sqlUpdate = "UPDATE admins SET username=?, password_hash=? WHERE admin_id=?";
$sqlSelect = "SELECT admin_id, username, password_hash FROM admins WHERE admin_id=?";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlUpdate, [
            $_POST['username'],
            $_POST['password_hash'],
            $_POST['admin_id']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}

$id = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST['admin_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }
$vals = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $row;

require "../header.php";
?>

<h2>Edit Admin</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>admin_id</label>
        <input type="number" name="admin_id" value="<?= htmlspecialchars($row['admin_id']) ?>" readonly>

        <label>username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($vals['username']) ?>" required>

        <label>password_hash</label>
        <input type="text" name="password_hash" value="<?= htmlspecialchars($vals['password_hash']) ?>" required>

        <br><br>
        <button type="submit" class="btn btn-warning">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sqlUpdate, $sqlSelect); ?>

<?php require "../footer.php"; ?>
