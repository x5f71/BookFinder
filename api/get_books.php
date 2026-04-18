<?php
/*
 * API Endpoint: get_books.php
 * Method:       GET
 * Params:       category, subcategory
 * Returns:      XML list of books matching the selected category and subcategory.
 *               Also includes a <loggedIn> flag so JavaScript can render the
 *               correct button (Order Book vs Login to Order).
 *
 * Used by book-search.js via XMLHttpRequest. The response is parsed using
 * responseXML and getElementsByTagName on the client side.
 */

include "../config/init.php";

header("Content-Type: application/xml; charset=UTF-8");

$category    = $_GET['category']    ?? '';
$subcategory = $_GET['subcategory'] ?? '';

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<books>';

// Pass login state to JavaScript so the correct button is rendered
echo '<loggedIn>' . ($loggedIn ? '1' : '0') . '</loggedIn>';

if (!$category || !$subcategory) {
    echo '</books>';
    exit;
}

// Prepared statement prevents SQL injection
$stmt = $conn->prepare("SELECT * FROM books WHERE category = ? AND subcategory = ?");
$stmt->bind_param("ss", $category, $subcategory);
$stmt->execute();
$result = $stmt->get_result();

// Build XML nodes for each matching book
while ($row = $result->fetch_assoc()) {
    echo '<book>';
    echo '<book_id>' . (int)$row['book_id']                   . '</book_id>';
    echo '<title>'   . htmlspecialchars($row['title'])         . '</title>';
    echo '<price>'   . htmlspecialchars($row['price'])         . '</price>';
    echo '<image>'   . htmlspecialchars($row['image'] ?? '')   . '</image>';
    echo '</book>';
}

echo '</books>';
