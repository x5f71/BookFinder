/*
 * book-search.js
 *
 * Handles all AJAX interactions for the book search feature using XMLHttpRequest.
 *
 * Two AJAX calls are made:
 *   1. loadSubcategories() — called when the category dropdown changes.
 *      Sends a GET request to api/get_subcategories.php and inserts the
 *      returned <option> HTML into the subcategory dropdown.
 *
 *   2. loadBooks() — called when the search button is clicked (or on page
 *      load on results.php if URL parameters are present).
 *      Sends a GET request to api/get_books.php, which returns an XML
 *      response. The XML is parsed using responseXML and getElementsByTagName
 *      to build and display the book listings.
 */


// ========================
// LOAD SUBCATEGORIES - AJAX
// ========================
function loadSubcategories(category, preselectSub) {

    // Clear the subcategory dropdown if no category is selected
    if (category === "") {
        document.getElementById("subcategory").innerHTML = "<option value='' disabled selected>Select Subcategory</option>";
        return;
    }

    // Create XMLHttpRequest object
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    // When the response is ready, insert the returned <option> elements into the dropdown
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("subcategory").innerHTML = this.responseText;

            // If arriving on results.php with URL params, pre-select the subcategory
            // and automatically load the matching books
            if (preselectSub) {
                document.getElementById("subcategory").value = preselectSub;
                loadBooks(preselectSub);
            }
        }
    };

    xmlhttp.open("GET", "api/get_subcategories.php?category=" + encodeURIComponent(category), true);
    xmlhttp.send();
}


// ========================
// LOAD BOOKS - AJAX (XML)
// ========================
function loadBooks(subcategory) {

    var category = document.getElementById("category").value;
    var booksDiv = document.getElementById("books");

    if (!subcategory || !category) return;

    // On index.php there is no #books div — navigate to results.php instead
    if (!booksDiv) {
        window.location.href = "results.php?category=" + encodeURIComponent(category) + "&subcategory=" + encodeURIComponent(subcategory);
        return;
    }

    // Create XMLHttpRequest object
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    // When the XML response is ready, parse it and render the book cards
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            // responseXML gives us a parsed XML document we can query like the DOM
            var xml      = this.responseXML;
            var books    = xml.getElementsByTagName("book");
            var loggedIn = xml.getElementsByTagName("loggedIn")[0].childNodes[0].nodeValue === "1";

            if (books.length === 0) {
                booksDiv.innerHTML = "<p>No books found for this selection.</p>";
                return;
            }

            var output = "";

            // Loop through each <book> and extract the child element values
            for (var i = 0; i < books.length; i++) {
                var title  = books[i].getElementsByTagName("title")[0].childNodes[0].nodeValue;
                var price  = books[i].getElementsByTagName("price")[0].childNodes[0].nodeValue;
                var bookId = books[i].getElementsByTagName("book_id")[0].childNodes[0].nodeValue;

                // Image is optional — fall back to a default if the field is empty
                var imageNode = books[i].getElementsByTagName("image")[0].childNodes[0];
                var imgSrc    = imageNode ? imageNode.nodeValue : "assets/images/default-book.png";
                if (!imgSrc)   imgSrc = "assets/images/default-book.png";

                // Show Order button for logged-in users, Login prompt for guests
                var orderBtn = loggedIn
                    ? "<a href='order.php?book_id=" + bookId + "' class='btn'>Order Book</a>"
                    : "<a href='login.php' class='btn'>Login to Order</a>";

                output += "<div class='book'>";
                output += "<div class='book-img'><img src='" + imgSrc + "' alt='" + title + "'></div>";
                output += "<h3>" + title + "</h3>";
                output += "<p>£" + price + "</p>";
                output += orderBtn;
                output += "</div>";
            }

            booksDiv.innerHTML = output;
        }
    };

    xmlhttp.open("GET", "api/get_books.php?category=" + encodeURIComponent(category) + "&subcategory=" + encodeURIComponent(subcategory), true);
    xmlhttp.send();
}


// ========================
// SEARCH BUTTON ON RESULTS PAGE
// ========================
// On results.php the form submit triggers an AJAX book search instead of a page reload.
// On index.php the form submits normally, navigating to results.php with URL params.
var form = document.querySelector(".book-search-widget");
if (form && document.getElementById("books")) {
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        loadBooks(document.getElementById("subcategory").value);
    });
}


// ========================
// AUTO-TRIGGER ON RESULTS PAGE
// ========================
// When the user arrives on results.php from the index.php search form, the category
// and subcategory are in the URL. This reads those params, pre-selects the dropdowns,
// and automatically loads the book results without any extra user interaction.
// The script is deferred so the DOM is fully ready before this runs.
var params        = new URLSearchParams(window.location.search);
var preCategory   = params.get("category");
var preSubcategory = params.get("subcategory");

if (preCategory && document.getElementById("books")) {
    document.getElementById("category").value = preCategory;
    loadSubcategories(preCategory, preSubcategory);
}
