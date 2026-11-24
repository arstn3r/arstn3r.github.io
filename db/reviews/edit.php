<?php
$base = "..";
require "../db.php";

$sqlUpdate = "UPDATE reviews SET customer_id=?, item_id=?, star_rating=?, review_date=? WHERE review_id=?";
$sqlSelect = "SELECT review_id, customer_id, item_id, star_rating, review_date FROM reviews WHERE review_id=?";
$sqlCust   = "SELECT customer_id, customer_name FROM customers ORDER BY customer_name";
$sqlItem   = "SELECT item_id, item_name FROM menu_items ORDER BY item_name";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sqlUpdate, [
            $_POST['customer_id'],
            $_POST['item_id'],
            $_POST['star_rating'],
            $_POST['review_date'],
            $_POST['review_id']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}

$id = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST['review_id'] : (isset($_GET['id']) ? $_GET['id'] : '');
$stmt = db_query($sqlSelect, [$id]);
$row = db_fetch($stmt);
if (!$row) { header("Location: list.php"); exit; }
$vals     = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $row;
$custStmt = db_query($sqlCust);
$itemStmt = db_query($sqlItem);

require "../header.php";
?>

<h2>Edit Review</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>review_id</label>
        <input type="number" name="review_id" value="<?= htmlspecialchars($row['review_id']) ?>" readonly>

        <label>customer_id</label>
        <select name="customer_id" required>
            <option value="">-- Select --</option>
            <?php while ($c = db_fetch($custStmt)): ?>
            <option value="<?= htmlspecialchars($c['customer_id']) ?>" <?= $c['customer_id'] == $vals['customer_id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['customer_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>item_id</label>
        <select name="item_id" required>
            <option value="">-- Select --</option>
            <?php while ($i = db_fetch($itemStmt)): ?>
            <option value="<?= htmlspecialchars($i['item_id']) ?>" <?= $i['item_id'] == $vals['item_id'] ? 'selected' : '' ?>><?= htmlspecialchars($i['item_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>star_rating</label>
        <input type="number" name="star_rating" value="<?= htmlspecialchars($vals['star_rating']) ?>" required>

        <label>review_date</label>
        <input type="date" name="review_date" value="<?= htmlspecialchars($vals['review_date']) ?>" required>

        <br><br>
        <button type="submit" class="btn btn-warning">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sqlUpdate, $sqlSelect, $sqlCust, $sqlItem); ?>

<?php require "../footer.php"; ?>
