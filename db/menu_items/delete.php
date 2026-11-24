<?php
$base = "..";
require "../db.php";

$sqlDelete = "DELETE FROM menu_items WHERE item_id=?";
$sqlSelect = "SELECT item_id, item_name, description, price, category_cd, is_available FROM menu_items WHERE item_id=?";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlDelete, [$_POST['item_id']]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Delete failed: " . $e->getMessage();
    }
}

$id = isset($_POST['item_id']) ? $_POST['item_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }

require "../header.php";
?>

<h2>Delete Menu Item</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<p>Are you sure you want to delete this record?</p>

<table>
    <tr><th>item_id</th><td><?= htmlspecialchars($row['item_id']) ?></td></tr>
    <tr><th>item_name</th><td><?= htmlspecialchars($row['item_name']) ?></td></tr>
    <tr><th>description</th><td><?= htmlspecialchars($row['description']) ?></td></tr>
    <tr><th>price</th><td><?= htmlspecialchars($row['price']) ?></td></tr>
    <tr><th>category_cd</th><td><?= htmlspecialchars($row['category_cd']) ?></td></tr>
    <tr><th>is_available</th><td><?= htmlspecialchars($row['is_available']) ?></td></tr>
</table>

<form method="POST">
    <input type="hidden" name="item_id" value="<?= htmlspecialchars($row['item_id']) ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php sql_box($sqlDelete, $sqlSelect); ?>

<?php require "../footer.php"; ?>
