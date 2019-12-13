<!-- Create IAT355 database -->
<?php

// Create connection
$servername = "localhost";
$username = "root";
$password = "";
$connection = mysqli_connect($servername, $username, $password);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// if the IAT355 database is not exist, create this database
// learn how to check if it exists from https://stackoverflow.com/questions/838978/how-to-check-if-mysql-database-exists
$sql = "CREATE DATABASE IF NOT EXISTS IAT355";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

// Close database connection
mysqli_close($connection);
?>


<!-- Create the appleStore table and googleStore table -->
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "IAT355";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to create appleStore table
$sqlForApple = "CREATE TABLE IF NOT EXISTS appleStore(
    app_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    app_name LONGTEXT NOT NULL,
    size_bytes BigInt NOT NULL,
    price NUMERIC(6, 2) NOT NULL,
    rating_count_total INTEGER NOT NULL,
    rating_count_current INTEGER NOT NULL,
    user_rating_total NUMERIC(3, 1) NOT NULL,
    user_rating_current NUMERIC(3, 1) NOT NULL,
    content_rating VARCHAR(17) NOT NULL,
    genre VARCHAR(17) NOT NULL,
    support_devices INTEGER NOT NULL,
    language_num INTEGER NOT NULL
);";

$resultForApple = mysqli_query($connection, $sqlForApple);

if (!$resultForApple) {
    die("Database query failed.");
}

// open apple sql file
$appleFile = fopen("appleStore.sql", "r") or die("Unable to open file!");

// make a select query to verify whether data is inserted or not
$selectQuery = "SELECT * FROM appleStore WHERE app_name = 'PAC-MAN Premium'";
$resultForSelect = mysqli_query($connection, $selectQuery);

// check select query return any rows, if there are no rows selected meaning there is no data
// so insert the data
// otherwise, data was already inserted
if (mysqli_num_rows($resultForSelect) == 0) {
    while (!feof($appleFile)) {
        $insertQuery = fgets($appleFile);
        $resultForInsert = mysqli_query($connection, $insertQuery);
        if (!$resultForInsert) {
            fclose($appleFile);
            die("Database query failed. " . mysqli_error($connection));
        }
    }
}

// close apple sql file
fclose($appleFile);

// create the googleStore table
$sqlForGoogle = "CREATE TABLE IF NOT EXISTS googleStore(
    app_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    app_name VARCHAR(194) NOT NULL,
    user_rating_total VARCHAR(3) NOT NULL,
    rating_count_total VARCHAR(8) NOT NULL,
    size_bytes VARCHAR(18) NOT NULL,
    install_total VARCHAR(14) NOT NULL,
    price VARCHAR(8) NOT NULL,
    content_rating VARCHAR(15) NULL,
    genre VARCHAR(37) NOT NULL,
    release_time VARCHAR(18) NOT NULL
);";

$resultForGoogle = mysqli_query($connection, $sqlForGoogle);

if (!$resultForGoogle) {
    die("Database query failed.");
}

// open apple sql file
$googleFile = fopen("googleStore.sql", "r") or die("Unable to open file!");

// make a select query to verify whether data is inserted or not
$selectQuery = "SELECT * FROM googleStore WHERE app_name = 'Photo Editor & Candy Camera & Grid & ScrapBook'";
$resultForSelect = mysqli_query($connection, $selectQuery);

// check select query return any rows, if there are no rows selected meaning there is no data
// so insert the data
// otherwise, data was already inserted
if (mysqli_num_rows($resultForSelect) == 0) {
    while (!feof($googleFile)) {
        $insertQuery = fgets($googleFile);
        $resultForInsert = mysqli_query($connection, $insertQuery);
        if (!$resultForInsert) {
            fclose($googleFile);
            die("Database query failed. " . mysqli_error($connection));
        }
    }
}

// close apple sql file
fclose($googleFile);

// close the connection
mysqli_close($connection);

?>

<!-- Modify appleStore dataset -->
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "IAT355";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// modify size_bytes column
$sql = "SELECT size_bytes FROM appleStore WHERE app_name = 'PAC-MAN Premium'";
$result = mysqli_query($connection, $sql);
$array = mysqli_fetch_assoc($result);
$valueForSizeBytes = $array["size_bytes"];

// avoid to execute query twice
if ($valueForSizeBytes > 1000000) {
    $sql = "UPDATE appleStore SET size_bytes =  size_bytes / 1000000";

    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Database query failed.");
    }
}

// modify content_rating column
$sql = "SELECT content_rating FROM appleStore WHERE app_id = 4096";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

$array = mysqli_fetch_assoc($result);
$valueForContentRating = $array["content_rating"];

// avoid to execute query twice
if ($valueForContentRating == "9+") {
    // query for 4+
    $sql = "UPDATE appleStore SET content_rating = 'Everyone' WHERE content_rating = '4+'";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        die("Database query failed.");
    }

    // query for 9+
    $sql = "UPDATE appleStore SET content_rating = 'Low maturity' WHERE content_rating = '9+'";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        die("Database query failed.");
    }

    // query for 12+
    $sql = "UPDATE appleStore SET content_rating = 'Medium maturity' WHERE content_rating = '12+'";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        die("Database query failed.");
    }

    // query for 17+
    $sql = "UPDATE appleStore SET content_rating = 'High maturity' WHERE content_rating = '17+'";
    $result = mysqli_query($connection, $sql);
    if (!$result) {
        die("Database query failed.");
    }
}

// close the connection
mysqli_close($connection);

?>

<!-- Modify googleStore dataset -->
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "IAT355";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// modify size_bytes column
$sql = "UPDATE googleStore SET size_bytes =  REPLACE(size_bytes, 'M', '')";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

$sql = "UPDATE googleStore SET size_bytes =  15 WHERE  size_bytes ='Varies with device'";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

// modify install_total column
$sql = "UPDATE googleStore SET install_total =  REPLACE(install_total, '+', '')";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

// modify price
$sql = "UPDATE googleStore SET price =  REPLACE(price, '$', '')";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

// modify content_rating

// query for NULL
$sql = "UPDATE googleStore SET content_rating = 'Everyone' WHERE content_rating IS NULL";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

// query for Everyone 10+
$sql = "UPDATE googleStore SET content_rating = 'Low maturity' WHERE content_rating = 'Everyone 10+'";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

// query for Teen
$sql = "UPDATE googleStore SET content_rating = 'Medium maturity' WHERE content_rating = 'Teen'";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

// query for Mature 17+
$sql = "UPDATE googleStore SET content_rating = 'High maturity' WHERE content_rating = 'Mature 17+'";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

// query for Adults only 18+
$sql = "UPDATE googleStore SET content_rating = 'High maturity' WHERE content_rating = 'Adults only 18+'";
$result = mysqli_query($connection, $sql);
if (!$result) {
    die("Database query failed.");
}

?>

<?php

echo "data wrangling succeed!";

?>

