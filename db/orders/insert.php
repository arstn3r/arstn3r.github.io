<?php
$base = "..";
require "../db.php";

$sql = "INSERT INTO orders (order_id, customer_id, order_date, total_price, status_cd)
        VALUES (?, ?, ?, ?, ?)";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sql, [
            $_POST['order_id'],
            $_POST['customer_id'],
            $_POST['order_date'],
            $_POST['total_price'],
            $_POST['status_cd']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Insert failed: " . $e->getMessage();
    }
}

$sqlCust = "SELECT customer_id, customer_name FROM customers ORDER BY customer_name";
$sqlStat = "SELECT status_cd, status_name FROM order_statuses ORDER BY status_name";
$custStmt = db_query($sqlCust);
$statStmt = db_query($sqlStat);

require "../header.php";
?>

<h2>Add an Order</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>order_id</label>
        <input type="number" name="order_id" required>

        <label>customer_id</label>
        <select name="customer_id" required>
            <option value="">-- Select --</option>
            <?php while ($c = db_fetch($custStmt)): ?>
            <option value="<?= htmlspecialchars($c['customer_id']) ?>"><?= htmlspecialchars($c['customer_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>order_date</label>
        <input type="date" name="order_date" required>

        <label>total_price</label>
        <input type="number" name="total_price" step="0.01" required>

        <label>status_cd</label>
        <select name="status_cd" required>
            <option value="">-- Select --</option>
            <?php while ($s = db_fetch($statStmt)): ?>
            <option value="<?= htmlspecialchars($s['status_cd']) ?>"><?= htmlspecialchars($s['status_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <br><br>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sql, $sqlCust, $sqlStat); ?>

<?php require "../footer.php"; ?>
