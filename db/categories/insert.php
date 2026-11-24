<?php
$base = "..";
require "../db.php";

$sql = "INSERT INTO categories (category_cd, category_name)
        VALUES (?, ?)";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sql, [
            $_POST['category_cd'],
            $_POST['category_name']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Insert failed: " . $e->getMessage();
    }
}

require "../header.php";
?>

<h2>Add a Category</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>category_cd</label>
        <input type="text" name="category_cd" required>

        <label>category_name</label>
        <input type="text" name="category_name" required>

        <br><br>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
