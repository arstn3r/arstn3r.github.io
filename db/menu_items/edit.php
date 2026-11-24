<?php
$base = "..";
require "../db.php";

$sqlUpdate = "UPDATE menu_items SET item_name=?, description=?, price=?, category_cd=?, is_available=? WHERE item_id=?";
$sqlSelect = "SELECT item_id, item_name, description, price, category_cd, is_available FROM menu_items WHERE item_id=?";
$sqlCat    = "SELECT category_cd, category_name FROM categories ORDER BY category_name";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlUpdate, [
            $_POST['item_name'],
            $_POST['description'],
            $_POST['price'],
            $_POST['category_cd'],
            $_POST['is_available'],
            $_POST['item_id']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}

$id = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST['item_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }
$vals = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $row;
$catStmt = db_query($sqlCat);

require "../header.php";
?>

<h2>Edit Menu Item</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>item_id</label>
        <input type="number" name="item_id" value="<?= htmlspecialchars($row['item_id']) ?>" readonly>

        <label>item_name</label>
        <input type="text" name="item_name" value="<?= htmlspecialchars($vals['item_name']) ?>" required>

        <label>description</label>
        <input type="text" name="description" value="<?= htmlspecialchars($vals['description']) ?>" required>

        <label>price</label>
        <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($vals['price']) ?>" required>

        <label>category_cd</label>
        <select name="category_cd" required>
            <option value="">-- Select --</option>
            <?php while ($c = db_fetch($catStmt)): ?>
            <option value="<?= htmlspecialchars($c['category_cd']) ?>" <?= $c['category_cd'] == $vals['category_cd'] ? 'selected' : '' ?>><?= htmlspecialchars($c['category_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>is_available</label>
        <select name="is_available" required>
            <option value="">-- Select --</option>
            <option value="1" <?= $vals['is_available'] == 1 ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= $vals['is_available'] == 0 ? 'selected' : '' ?>>No</option>
        </select>

        <br><br>
        <button type="submit" class="btn btn-warning">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sqlUpdate, $sqlSelect, $sqlCat); ?>

<?php require "../footer.php"; ?>
