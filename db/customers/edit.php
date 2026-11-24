<?php
$base = "..";
require "../db.php";

$sqlUpdate = "UPDATE customers SET customer_name=?, email=?, password_hash=?, phone=?, is_active=? WHERE customer_id=?";
$sqlSelect = "SELECT customer_id, customer_name, email, password_hash, phone, is_active FROM customers WHERE customer_id=?";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlUpdate, [
            $_POST['customer_name'],
            $_POST['email'],
            $_POST['password_hash'],
            $_POST['phone'],
            $_POST['is_active'],
            $_POST['customer_id']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}

$id = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST['customer_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }
$vals = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $row;

require "../header.php";
?>

<h2>Edit Customer</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>customer_id</label>
        <input type="number" name="customer_id" value="<?= htmlspecialchars($row['customer_id']) ?>" readonly>

        <label>customer_name</label>
        <input type="text" name="customer_name" value="<?= htmlspecialchars($vals['customer_name']) ?>" required>

        <label>email</label>
        <input type="text" name="email" value="<?= htmlspecialchars($vals['email']) ?>" required>

        <label>password_hash</label>
        <input type="text" name="password_hash" value="<?= htmlspecialchars($vals['password_hash']) ?>" required>

        <label>phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($vals['phone']) ?>" required>

        <label>is_active</label>
        <select name="is_active" required>
            <option value="">-- Select --</option>
            <option value="1" <?= $vals['is_active'] == 1 ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= $vals['is_active'] == 0 ? 'selected' : '' ?>>No</option>
        </select>

        <br><br>
        <button type="submit" class="btn btn-warning">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sqlUpdate, $sqlSelect); ?>

<?php require "../footer.php"; ?>
