<?php
$base = "..";
require "../db.php";

$sql = "INSERT INTO menu_items (item_id, item_name, description, price, category_cd, is_available)
        VALUES (?, ?, ?, ?, ?, ?)";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sql, [
            $_POST['item_id'],
            $_POST['item_name'],
            $_POST['description'],
            $_POST['price'],
            $_POST['category_cd'],
            $_POST['is_available']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Insert failed: " . $e->getMessage();
    }
}

$sqlCat = "SELECT category_cd, category_name FROM categories ORDER BY category_name";
$catStmt = db_query($sqlCat);

require "../header.php";
?>

<h2>Add a Menu Item</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>item_id</label>
        <input type="number" name="item_id" required>

        <label>item_name</label>
        <input type="text" name="item_name" required>

        <label>description</label>
        <input type="text" name="description" required>

        <label>price</label>
        <input type="number" name="price" step="0.01" required>

        <label>category_cd</label>
        <select name="category_cd" required>
            <option value="">-- Select --</option>
            <?php while ($c = db_fetch($catStmt)): ?>
            <option value="<?= htmlspecialchars($c['category_cd']) ?>"><?= htmlspecialchars($c['category_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>is_available</label>
        <select name="is_available" required>
            <option value="">-- Select --</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <br><br>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sql, $sqlCat); ?>

<?php require "../footer.php"; ?>
