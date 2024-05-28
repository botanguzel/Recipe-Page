<?php
    // SQL Server Extension Sample Code:
    $connectionInfo = array("UID" => "botan", "pwd" => "Xwedeteala1.", "Database" => "botanguzelDB", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
    $serverName = "tcp:botanguzeldb.database.windows.net,1433";
    $con = sqlsrv_connect($serverName, $connectionInfo);
    if ($con === false) {
        die(print_r(sqlsrv_errors(), true));
    }

?>