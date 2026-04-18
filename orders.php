<?php
include "config/init.php";

// check login
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION["user"]["email"];

// fetch orders
$stmt = $conn->prepare("
    SELECT * FROM orders 
    WHERE email = ? 
    ORDER BY created_at DESC
");

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Orders | BookFinder</title>
    <meta name="description" content="View your order history on BookFinder. Track previously ordered books including titles, prices and order dates.">
    <?php include "includes/head.php"; ?>
</head>

<body>
    <?php include "includes/navigation.php"; ?>

<main class="main-wrap">
    <div class="wrapper">
        <div class="container">

            <h1>My Orders</h1>
            <br>

            <?php if ($result->num_rows > 0) { ?>

                <div class="orders-grid">

                    <?php while ($row = $result->fetch_assoc()) { ?>

                        <div class="order-card">

                            <h3><?php echo htmlspecialchars($row["book_title"]); ?></h3>
                            <hr>
                            <p><strong>Price:</strong> £<?php echo htmlspecialchars($row["price"]); ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($row["created_at"]); ?></p>
                            <p><strong>Order Number:</strong> #<?php echo (int)$row["order_id"]; ?></p>

                        </div>

                    <?php } ?>

                </div>

            <?php } else { ?>

                <p>You have not placed any orders yet.</p>

                <br>

                <a href="results.php" class="btn">
                    Browse Books
                </a>

            <?php } ?>

        </div>
    </div>

    <section class="cta-section">
        <div class="wrapper">
            <div class="container">
                <div class="cta">
                    <h2>Looking for more books?</h2>
                    <p>Check out some more of our books to find your next read!</p>
                    <a href="index.php" class="btn">Find More</a> 
                </div>
                
            </div>
        </div>

    </section>
</main>

<?php include "includes/footer.php"; ?>

</body>
</html>