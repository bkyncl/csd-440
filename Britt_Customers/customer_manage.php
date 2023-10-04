<!--
customer_manage.php
Module 5 Assignment
Name: Brittany Kyncl
Date: 9.2.23
Course: CSD440
Main component of customer search system including functions to display customer data and search for customers by various criteria.
-->
<?php
$customers = array(
    array(
        "first_name" => "John",
        "last_name" => "Doe",
        "age" => 35,
        "phone" => "555-123-4567"
    ),
    array(
        "first_name" => "Jane",
        "last_name" => "Smith",
        "age" => 28,
        "phone" => "555-987-6543"
    ),
    array(
        "first_name" => "Alice",
        "last_name" => "Johnson",
        "age" => 42,
        "phone" => "555-555-5555"
    ),
    array(
        "first_name" => "Bob",
        "last_name" => "Williams",
        "age" => 55,
        "phone" => "555-111-2222"
    ),
    array(
        "first_name" => "Eve",
        "last_name" => "Adams",
        "age" => 30,
        "phone" => "555-333-4444"
    ),
    array(
        "first_name" => "Charlie",
        "last_name" => "Brown",
        "age" => 21,
        "phone" => "555-666-7777"
    ),
    array(
        "first_name" => "Grace",
        "last_name" => "Davis",
        "age" => 48,
        "phone" => "555-999-0000"
    ),
    array(
        "first_name" => "David",
        "last_name" => "Miller",
        "age" => 63,
        "phone" => "555-777-8888"
    ),
    array(
        "first_name" => "Sophia",
        "last_name" => "Moore",
        "age" => 25,
        "phone" => "555-222-3333"
    ),
    array(
        "first_name" => "Oliver",
        "last_name" => "Anderson",
        "age" => 37,
        "phone" => "555-444-5555"
    ),
    array(
        "first_name" => "Liam",
        "last_name" => "Martinez",
        "age" => 29,
        "phone" => "555-888-9999"
    ),
);

/**
 * Display a table of all customers with keys as column headings and values as data.
 *
 * @param array $customers An array (customers container) of associative arrays (single customer)
 */
function displayAllCustomers($customers) {
    if (empty($customers)) {
        echo "<tr>";
        echo "<td>No customers found to display.</td>";
        echo "</tr>";
    } else {
        // Print the header row with keys as column headings
        echo "<tr>";
        foreach ($customers[0] as $key => $value) { // iterate through keys of first associative array for print (all customers have same key)
            echo "<th>$key</th>";
        }
        echo "</tr>";

        // Print data rows with corresponding values
        foreach ($customers as $customer) { // iterate through each key/value of associative array (customer) and display only value
            echo "<tr>";
            foreach ($customer as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
    }
}
/**
 * Search for customers based on a specific key and value.
 *
 * @param string $searchKey The key to search for (e.g., 'first_name', 'last_name', 'age', 'phone')
 * @param string $searchValue The value to search for within the specified key
 * @param array $customers An array (customers container) of associative arrays (single customer)
 * @return array An array of matching customer records
 */
function searchCustomersByKey($searchKey, $searchValue, $customers) {
    // Initialize an array to store the matching customer records.
    $results = array();

    foreach ($customers as $customer) { 
        // Check if the specified search key exists in the customer record and if the search value is found (case-insensitive).
        if (isset($customer[$searchKey]) && stripos($customer[$searchKey], $searchValue) !== false) {
            $results[] = $customer;  // If a match is found, add the customer record to the results array.
        }
    }

    return $results;
}

// Check if the form has been submitted and the search button ('search_submit') was clicked.
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search_submit'])) {
    // Retrieve form data
    $searchKey = $_POST['search_key'];
    $searchValue = trim($_POST['search_value']);

    // Perform validation checks on $searchValue
    if (empty($searchValue)) {
        $errors[] = "Search value cannot be empty.";
    } else {
        // Perform specific validation checks based on the search key
        if ($searchKey === 'age') {
            if (!is_numeric($searchValue) || $searchValue != (int)$searchValue) {
                $errors[] = "Age must be an integer.";
            }
        } elseif ($searchKey === 'phone') {
            if (!preg_match("/^\d{3}-\d{3}-\d{4}$/", $searchValue) || !is_numeric(str_replace("-", "", $searchValue))) {
                $errors[] = "Phone number must be numeric and in 123-123-3456 format.";
            }
        } elseif (in_array($searchKey, ['first_name', 'last_name'])) {
            // Check if first_name or last_name contains only string characters (letters and spaces)
            if (!ctype_alpha(str_replace(' ', '', $searchValue))) {
                $errors[] = ucfirst($searchKey) . " must contain only letters.";
            }
        }
    }

    // If there are no validation errors, perform the search
    if (empty($errors)) {
        // Perform the search and store results in $searchResults
        $searchResults = searchCustomersByKey($searchKey, $searchValue, $customers);
    }
}
?>