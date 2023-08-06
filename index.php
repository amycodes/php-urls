<?php

require_once 'src/functions.php';

router('GET', '^/$', function() {
    echo "Where would you like to go?";
    exit();
});

// With named parameters
router('GET', '/(?<slug>[a-zA-Z0-9]*)$', function($params) {
    echo "You selected User-ID: " . $params['slug'];
    $conn = mysqli_connect(getenv("MYSQLHOST"), getenv("MYSQLUSER"), getenv("MYSQLPASSWORD"), getenv("MYSQLDATABASE"), getenv("MYSQLPORT"));
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $query = sprintf("select url from railway.aliases where slug = '%s'", $params['slug']);
    $r = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($r,MYSQLI_ASSOC);
    print_r($row);
    mysqli_close($conn);
    if ( empty($row['url']) ) {
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
        exit();
    } else {
        header("Location: " . $row['url']);
    }
});

//header("HTTP/1.0 404 Not Found");
echo '404 Not Found';