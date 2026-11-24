<?php
$base = "..";
require "../db.php";

$sqlDelete = "DELETE FROM reviews WHERE review_id=?";
$sqlSelect = "SELECT review_id, customer_id, item_id, star_rating, review_date FROM reviews WHERE review_id=?";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlDelete, [$_POST['review_id']]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Delete failed: " . $e->getMessage();
    }
}

$id = isset($_POST['review_id']) ? $_POST['review_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }

require "../header.php";
?>

<h2>Delete Review</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<p>Are you sure you want to delete this record?</p>

<table>
    <tr><th>review_id</th><td><?= htmlspecialchars($row['review_id']) ?></td></tr>
    <tr><th>customer_id</th><td><?= htmlspecialchars($row['customer_id']) ?></td></tr>
    <tr><th>item_id</th><td><?= htmlspecialchars($row['item_id']) ?></td></tr>
    <tr><th>star_rating</th><td><?= htmlspecialchars($row['star_rating']) ?></td></tr>
    <tr><th>review_date</th><td><?= htmlspecialchars($row['review_date']) ?></td></tr>
</table>

<form method="POST">
    <input type="hidden" name="review_id" value="<?= htmlspecialchars($row['review_id']) ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>

<?php sql_box($sqlDelete, $sqlSelect); ?>

<?php require "../footer.php"; ?>
