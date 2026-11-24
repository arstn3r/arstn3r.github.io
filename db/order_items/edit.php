<?php
$base = "..";
require "../db.php";

$sqlUpdate = "UPDATE order_items SET order_id=?, item_id=?, quantity=?, unit_price=? WHERE order_item_id=?";
$sqlSelect = "SELECT order_item_id, order_id, item_id, quantity, unit_price FROM order_items WHERE order_item_id=?";
$sqlOrd    = "SELECT order_id FROM orders ORDER BY order_id";
$sqlItem   = "SELECT item_id, item_name FROM menu_items ORDER BY item_name";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlUpdate, [
            $_POST['order_id'],
            $_POST['item_id'],
            $_POST['quantity'],
            $_POST['unit_price'],
            $_POST['order_item_id']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}

$id = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST['order_item_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }
$vals     = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $row;
$ordStmt  = db_query($sqlOrd);
$itemStmt = db_query($sqlItem);

require "../header.php";
?>

<h2>Edit Order Item</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>order_item_id</label>
        <input type="number" name="order_item_id" value="<?= htmlspecialchars($row['order_item_id']) ?>" readonly>

        <label>order_id</label>
        <select name="order_id" required>
            <option value="">-- Select --</option>
            <?php while ($o = db_fetch($ordStmt)): ?>
            <option value="<?= htmlspecialchars($o['order_id']) ?>" <?= $o['order_id'] == $vals['order_id'] ? 'selected' : '' ?>><?= htmlspecialchars($o['order_id']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>item_id</label>
        <select name="item_id" required>
            <option value="">-- Select --</option>
            <?php while ($i = db_fetch($itemStmt)): ?>
            <option value="<?= htmlspecialchars($i['item_id']) ?>" <?= $i['item_id'] == $vals['item_id'] ? 'selected' : '' ?>><?= htmlspecialchars($i['item_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>quantity</label>
        <input type="number" name="quantity" value="<?= htmlspecialchars($vals['quantity']) ?>" required>

        <label>unit_price</label>
        <input type="number" name="unit_price" step="0.01" value="<?= htmlspecialchars($vals['unit_price']) ?>" required>

        <br><br>
        <button type="submit" class="btn btn-warning">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sqlUpdate, $sqlSelect, $sqlOrd, $sqlItem); ?>

<?php require "../footer.php"; ?>
