
<?php
include "config/init.php";
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | BookFinder</title>
    <meta name="description" content="Create a BookFinder account to browse and order books online.">

    <?php include "includes/head.php"; ?>

    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
</head>

<body>

    <?php include "includes/navigation.php";?>

    <main class="main-wrap">

        <div class="wrapper">
            <div class="container">

                <div class="form-container">
                    <div class="form-card">
                        <h1>Register your account</h1>
                        <div id="root"></div>
                    </div>
                </div>

            </div>
        </div>

    </main>

    

    <?php include "includes/footer.php"; ?>


    <script type="text/babel" src="scripts/register.js"></script>

</body>
</html>

