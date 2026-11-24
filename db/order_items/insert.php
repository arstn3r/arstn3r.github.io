<?php
$base = "..";
require "../db.php";

$sql = "INSERT INTO order_items (order_item_id, order_id, item_id, quantity, unit_price)
        VALUES (?, ?, ?, ?, ?)";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sql, [
            $_POST['order_item_id'],
            $_POST['order_id'],
            $_POST['item_id'],
            $_POST['quantity'],
            $_POST['unit_price']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Insert failed: " . $e->getMessage();
    }
}

$sqlOrd  = "SELECT order_id FROM orders ORDER BY order_id";
$sqlItem = "SELECT item_id, item_name FROM menu_items ORDER BY item_name";
$ordStmt  = db_query($sqlOrd);
$itemStmt = db_query($sqlItem);

require "../header.php";
?>

<h2>Add an Order Item</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>order_item_id</label>
        <input type="number" name="order_item_id" required>

        <label>order_id</label>
        <select name="order_id" required>
            <option value="">-- Select --</option>
            <?php while ($o = db_fetch($ordStmt)): ?>
            <option value="<?= htmlspecialchars($o['order_id']) ?>"><?= htmlspecialchars($o['order_id']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>item_id</label>
        <select name="item_id" required>
            <option value="">-- Select --</option>
            <?php while ($i = db_fetch($itemStmt)): ?>
            <option value="<?= htmlspecialchars($i['item_id']) ?>"><?= htmlspecialchars($i['item_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>quantity</label>
        <input type="number" name="quantity" required>

        <label>unit_price</label>
        <input type="number" name="unit_price" step="0.01" required>

        <br><br>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sql, $sqlOrd, $sqlItem); ?>

<?php require "../footer.php"; ?>
