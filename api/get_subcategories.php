<?php
/*
 * API Endpoint: get_subcategories.php
 * Method:       GET
 * Params:       category (Kids or Adults)
 * Returns:      HTML <option> elements for the subcategory dropdown.
 *
 * Called via XMLHttpRequest when the user changes the category dropdown.
 * The response is inserted directly into the subcategory <select> using innerHTML.
 * Subcategory values are queried from the database to stay in sync with available stock.
 */

include "../config/db.php";

$category = $_GET['category'] ?? '';

if (empty($category)) {
    echo '<option value="" disabled selected>Select Subcategory</option>';
    exit;
}

// Maps database values to human-readable display labels
$labelMap = [
    "Classic"  => "Classic Novels",
    "Comic"    => "Comic Books",
    "Crime"    => "Crime and Thriller",
    "Fiction"  => "Fiction",
    "Infants"  => "Infants",
    "Junior"   => "Junior",
    "Young"    => "Young",
];

// Prepared statement prevents SQL injection
$stmt = $conn->prepare("SELECT DISTINCT subcategory FROM books WHERE category = ? ORDER BY subcategory");
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

echo '<option value="" disabled selected>Select Subcategory</option>';

while ($row = $result->fetch_assoc()) {
    $value = htmlspecialchars($row['subcategory']);
    $label = htmlspecialchars($labelMap[$row['subcategory']] ?? $row['subcategory']);
    echo "<option value=\"$value\">$label</option>";
}
