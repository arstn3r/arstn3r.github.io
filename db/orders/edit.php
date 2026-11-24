<?php
$base = "..";
require "../db.php";

$sqlUpdate = "UPDATE orders SET customer_id=?, order_date=?, total_price=?, status_cd=? WHERE order_id=?";
$sqlSelect = "SELECT order_id, customer_id, order_date, total_price, status_cd FROM orders WHERE order_id=?";
$sqlCust   = "SELECT customer_id, customer_name FROM customers ORDER BY customer_name";
$sqlStat   = "SELECT status_cd, status_name FROM order_statuses ORDER BY status_name";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlUpdate, [
            $_POST['customer_id'],
            $_POST['order_date'],
            $_POST['total_price'],
            $_POST['status_cd'],
            $_POST['order_id']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}

$id = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST['order_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }
$vals     = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $row;
$custStmt = db_query($sqlCust);
$statStmt = db_query($sqlStat);

require "../header.php";
?>

<h2>Edit Order</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>order_id</label>
        <input type="number" name="order_id" value="<?= htmlspecialchars($row['order_id']) ?>" readonly>

        <label>customer_id</label>
        <select name="customer_id" required>
            <option value="">-- Select --</option>
            <?php while ($c = db_fetch($custStmt)): ?>
            <option value="<?= htmlspecialchars($c['customer_id']) ?>" <?= $c['customer_id'] == $vals['customer_id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['customer_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>order_date</label>
        <input type="date" name="order_date" value="<?= htmlspecialchars($vals['order_date']) ?>" required>

        <label>total_price</label>
        <input type="number" name="total_price" step="0.01" value="<?= htmlspecialchars($vals['total_price']) ?>" required>

        <label>status_cd</label>
        <select name="status_cd" required>
            <option value="">-- Select --</option>
            <?php while ($s = db_fetch($statStmt)): ?>
            <option value="<?= htmlspecialchars($s['status_cd']) ?>" <?= $s['status_cd'] == $vals['status_cd'] ? 'selected' : '' ?>><?= htmlspecialchars($s['status_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <br><br>
        <button type="submit" class="btn btn-warning">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sqlUpdate, $sqlSelect, $sqlCust, $sqlStat); ?>

<?php require "../footer.php"; ?>
