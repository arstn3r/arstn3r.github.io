<?php
$base = "..";
require "../db.php";

$sql = "INSERT INTO order_statuses (status_cd, status_name)
        VALUES (?, ?)";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sql, [
            $_POST['status_cd'],
            $_POST['status_name']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Insert failed: " . $e->getMessage();
    }
}

require "../header.php";
?>

<h2>Add an Order Status</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>status_cd</label>
        <input type="text" name="status_cd" required>

        <label>status_name</label>
        <input type="text" name="status_name" required>

        <br><br>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
