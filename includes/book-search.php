<form action="results.php" method="GET" class="book-search-widget">

    <div class="select-wrapper">
        <label class="visually-hidden" for="category">Category</label>
        <select id="category" name="category" class="search-select" required onchange="loadSubcategories(this.value)">
            <option value="" disabled selected>Select Category</option>
            <option value="Kids">Kids</option>
            <option value="Adults">Adults</option>
        </select>
    </div>

    <div class="select-wrapper">
        <label class="visually-hidden" for="subcategory">Subcategory</label>
        <select id="subcategory" name="subcategory" class="search-select" required>
            <option value="" disabled selected>Select Subcategory</option>
        </select>
    </div>

    <button type="submit" class="btn search-btn">
        Search Books
    </button>

</form>

<script defer src="scripts/book-search.js"></script>
