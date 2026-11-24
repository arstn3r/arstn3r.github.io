<?php
$base = "..";
require "../db.php";

$sql = "INSERT INTO reviews (review_id, customer_id, item_id, star_rating, review_date)
        VALUES (?, ?, ?, ?, ?)";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sql, [
            $_POST['review_id'],
            $_POST['customer_id'],
            $_POST['item_id'],
            $_POST['star_rating'],
            $_POST['review_date']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Insert failed: " . $e->getMessage();
    }
}

$sqlCust = "SELECT customer_id, customer_name FROM customers ORDER BY customer_name";
$sqlItem = "SELECT item_id, item_name FROM menu_items ORDER BY item_name";
$custStmt = db_query($sqlCust);
$itemStmt = db_query($sqlItem);

require "../header.php";
?>

<h2>Add a Review</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>review_id</label>
        <input type="number" name="review_id" required>

        <label>customer_id</label>
        <select name="customer_id" required>
            <option value="">-- Select --</option>
            <?php while ($c = db_fetch($custStmt)): ?>
            <option value="<?= htmlspecialchars($c['customer_id']) ?>"><?= htmlspecialchars($c['customer_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>item_id</label>
        <select name="item_id" required>
            <option value="">-- Select --</option>
            <?php while ($i = db_fetch($itemStmt)): ?>
            <option value="<?= htmlspecialchars($i['item_id']) ?>"><?= htmlspecialchars($i['item_name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>star_rating</label>
        <input type="number" name="star_rating" required>

        <label>review_date</label>
        <input type="date" name="review_date" required>

        <br><br>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sql, $sqlCust, $sqlItem); ?>

<?php require "../footer.php"; ?>
