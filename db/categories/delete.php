<?php
$base = "..";
require "../db.php";

$sqlDelete = "DELETE FROM categories WHERE category_cd=?";
$sqlSelect = "SELECT category_cd, category_name FROM categories WHERE category_cd=?";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlDelete, [$_POST['category_cd']]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Delete failed: " . $e->getMessage();
    }
}

$id = isset($_POST['category_cd']) ? $_POST['category_cd'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }

require "../header.php";
?>

<h2>Delete Category</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<p>Are you sure you want to delete this record?</p>

<table>
    <tr><th>category_cd</th><td><?= htmlspecialchars($row['category_cd']) ?></td></tr>
    <tr><th>category_name</th><td><?= htmlspecialchars($row['category_name']) ?></td></tr>
</table>

<form method="POST">
    <input type="hidden" name="category_cd" value="<?= htmlspecialchars($row['category_cd']) ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php sql_box($sqlDelete, $sqlSelect); ?>

<?php require "../footer.php"; ?>
