<!DOCTYPE html>
<html lang="en">
<head>
    <title>BookFinder | Browse & Order Books Online</title>
    <meta name="description" content="BookFinder lets you browse and discover books across multiple genres including kids, fiction, comics and crime. Register to place orders and track your purchases online.">
    <?php include "includes/head.php"; ?>

</head>
<body class="pg-index">

<?php include "includes/navigation.php"; ?>
<main class="main-wrap">
    <div id="hero-search" class="hero-unit" role="banner">
        <div class="wrapper">
            <div class="container">
                <div class="hero-unit-block">

                    <div class="hero-unit__text">
                        <h1>Welcome to BookFinder</h1>
                        <p>Search through our wide range of books available.</p>
                    </div>

                    <div class="hero-book-search">
                        <?php include "includes/book-search.php"; ?>
                    </div> 

                </div>
            </div>
        </div>
    </div>

    <section class="info-section">
        <div class="wrapper">
            <div class="container">
                <div class="info-section__item">
                    <div class="text-content">
                        <h2>Wide Selection</h2>
                        <p>We offer a wide range of books to suit readers of all ages and interests, from engaging children's stories to classic novels, fiction, comics, and thrilling crime titles. Our collection is carefully organised into categories to make browsing simple and efficient, allowing users to quickly find books that match their preferences. Each book is presented with clear details and pricing, ensuring a smooth and enjoyable online shopping experience.</p>
                    </div>
                    <div class="info-img">
                        <img src="assets/images/books.webp" alt="Collection of books on shelves" loading="lazy">
                    </div>
                </div>
                <div class="info-section__item info-section__item--reverse">
                    <div class="info-img">
                        <img src="assets/images/reading.webp" alt="Person reading a book indoors" loading="lazy">
                    </div>
                    <div class="text-content">
                        <h2>Want to get into reading?</h2>
                        <p>Our bookstore is the perfect place to start. Whether you are new to reading or looking to rediscover your passion, we provide a variety of beginner-friendly books across different genres and age groups. With easy navigation and carefully selected categories, users can explore new interests and find books that suit their reading level, making it simple and enjoyable to build a regular reading habit.</p>
                    </div>
                    
                </div>
                
            </div>
        </div>
        
    </section>

    <section class="cta-section">
        <div class="wrapper">
            <div class="container">
                <div class="cta">
                    <h2>Ready to Find Your Next Book?</h2>
                    <p>Find a book today and start your next great read. Browse our collection to discover titles that match your interests and enjoy a simple, hassle-free experience.</p>
                    <a href="#hero-search" class="btn">Start Searching</a> 
                </div>
                
            </div>
        </div>

    </section>
</main>



<?php include "includes/footer.php"; ?>



<script src="scripts/index.js"></script>


</body>
</html>