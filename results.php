<?php
include "config/init.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BookFinder | Search Book Results</title>
    <meta name="description" content="Browse filtered book results by category and subcategory. Find fiction, comics, classics and more with clear pricing and easy ordering for registered users.">
    <?php include "includes/head.php"; ?>
</head>

<body>
    <?php include "includes/navigation.php"; ?>

<main class="main-wrap">

    <div class="wrapper">
        <div class="container">

            <div class="results-book-search">
                <h2>Search for a book</h2>
                <?php include "includes/book-search.php"; ?>
            </div>

            <h1>Search Results</h1>
            <br>

            <div class="book-results" id="books"></div>

        </div>
    </div>

</main>

<?php include "includes/footer.php"; ?>

</body>
</html>
