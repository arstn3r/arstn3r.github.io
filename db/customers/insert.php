<?php
$base = "..";
require "../db.php";

$sql = "INSERT INTO customers (customer_id, customer_name, email, password_hash, phone, is_active)
        VALUES (?, ?, ?, ?, ?, ?)";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        db_query($sql, [
            $_POST['customer_id'],
            $_POST['customer_name'],
            $_POST['email'],
            $_POST['password_hash'],
            $_POST['phone'],
            $_POST['is_active']
        ]);
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $error = "Insert failed: " . $e->getMessage();
    }
}

require "../header.php";
?>

<h2>Add a Customer</h2>

<?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="form-box">
    <form method="POST">
        <label>customer_id</label>
        <input type="number" name="customer_id" required>

        <label>customer_name</label>
        <input type="text" name="customer_name" required>

        <label>email</label>
        <input type="text" name="email" required>

        <label>password_hash</label>
        <input type="text" name="password_hash" required>

        <label>phone</label>
        <input type="text" name="phone" required>

        <label>is_active</label>
        <select name="is_active" required>
            <option value="">-- Select --</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <br><br>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php sql_box($sql); ?>

<?php require "../footer.php"; ?>
