<?php
include "config/init.php";

// check login
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// validate book id
$bookId = isset($_GET["book_id"]) ? (int)$_GET["book_id"] : 0;

if ($bookId <= 0) {
    echo "Invalid book.";
    exit;
}

// get book details
$stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
$stmt->bind_param("i", $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Book not found.";
    exit;
}

$book = $result->fetch_assoc();

// get user from session
$user = $_SESSION["user"];

// handle order submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $insert = $conn->prepare("
    INSERT INTO orders (name, email, phone, book_id, book_title, price)
    VALUES (?, ?, ?, ?, ?, ?)
");

$insert->bind_param(
    "sssisd",
    $user["name"],
    $user["email"],
    $user["phone"],
    $book["book_id"],
    $book["title"],
    $book["price"]
);
    if ($insert->execute()) {
        header("Location: orders.php?success=1");
        exit;
    } else {
        $error = "Failed to place order.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Book | BookFinder</title>
    <meta name="description" content="Review and confirm your book order on BookFinder. Check your selected title, price and personal details before placing your order securely.">
    <?php include "includes/head.php"; ?>
</head>

<body>
<?php include "includes/navigation.php"; ?>

<main class="main-wrap">
    <div class="wrapper">
        <div class="container">

            <h1>Order Book</h1>
            <br>

            <div class="order-box">
                <div class="order-content">

                    <div class="order-img">
                        <img 
                            src="<?php echo !empty($book['image']) ? htmlspecialchars($book['image']) : 'assets/images/default-book.png'; ?>" 
                            alt="<?php echo htmlspecialchars($book['title']); ?>">
                    </div>

                    <div class="order-text">

                        <div class="order-details">
                            <h2><?php echo htmlspecialchars($book["title"]); ?></h2>

                            <p class="detail-item">
                                <strong>Book ID:</strong> 
                                <span>#<?php echo htmlspecialchars($book["book_id"]); ?></span>
                            </p>


                            <p class="detail-item">
                                <strong>Price:</strong> 
                                <span>£<?php echo htmlspecialchars($book["price"]); ?></span>
                            </p>

                            <hr>
                            <br>

                            <h3>Your Details</h3>

                            <p class="detail-item">
                                <strong>Name:</strong> 
                                <span><?php echo htmlspecialchars($user["name"]); ?></span>
                            </p>

                            <p class="detail-item">
                                <strong>Email:</strong> 
                                <span><?php echo htmlspecialchars($user["email"]); ?></span>
                            </p>

                            <p class="detail-item">
                                <strong>Phone:</strong> 
                                <span><?php echo htmlspecialchars($user["phone"]); ?></span>
                            </p>
                        </div>
                            <br>
                        <form method="POST">
                            <button 
                                type="submit" 
                                class="btn"
                                onclick="this.disabled=true; this.form.submit();"
                            >
                                Confirm Order
                            </button>
                        </form>

                        <?php if (isset($success)) { ?>
                            <p style="color: green;">
                                <?php echo htmlspecialchars($success); ?>
                            </p>
                            <script>
                                alert("<?php echo htmlspecialchars($success); ?>");
                                window.location.href = "orders.php?success=1";
                            </script>
                        <?php } ?>

                        <?php if (isset($error)) { ?>
                            <p style="color: red;">
                                <?php echo htmlspecialchars($error); ?>
                            </p>
                        <?php } ?>

                    </div>       
                </div>
            </div>

        </div>
    </div>

    <section class="cta-section">
        <div class="wrapper">
            <div class="container">
                <div class="cta">
                    <h2>Not quite what you're looking for?</h2>
                    <p>
                        Not what you’re looking for? Don’t worry, we have a wide range of books across all categories 
                        to suit every reader. You can easily go back and explore more titles until you find the perfect match.
                    </p>
                    <a href="index.php" class="btn">Back to Search</a> 
                </div>
            </div>
        </div>
    </section>

</main>

<?php include "includes/footer.php"; ?>

</body>
</html>