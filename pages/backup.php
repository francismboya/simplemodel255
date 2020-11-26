<?php

$con = mysqli_connect('localhost', 'remote', '123456', 'kipawa');

$tables = array();

$result = mysqli_query($con, "SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}
$return = "SET GLOBAL max_allowed_packet=1024*1024*1024;";

$return .= "\n\nSET FOREIGN_KEY_CHECKS = 0;\n\n";

foreach ($tables as $table) {
    $result = mysqli_query($con, "SELECT * FROM " . $table);
    $num_fields = mysqli_num_fields($result);

    $return .= "\n\nDROP TABLE IF EXISTS " . $table . ";\n\n";
    $row2 = mysqli_fetch_row(mysqli_query($con, 'SHOW CREATE TABLE ' . $table));
    $return .= "\n\n" . $row2[1] . ";\n\n";

    for ($i = 0; $i < $num_fields; $i++) {
        while ($row = mysqli_fetch_row($result)) {
            $return .= 'INSERT INTO ' . $table . ' VALUES(';
            for ($j = 0; $j < $num_fields; $j++) {
                $row[$j] = addslashes($row[$j]);
                if (isset($row[$j])) {
                    $return .= '"' . $row[$j] . '"';} else { $return .= '""';}
                if ($j < $num_fields - 1) {$return .= ',';}
            }
            $return .= ");\n";
        }
    }
    $return .= "\n\n\n";

}
$return .= "\n\nSET FOREIGN_KEY_CHECKS = 1;\n\n";

$handle = fopen('backup.sql', 'w+');
fwrite($handle, $return);
fclose($handle);
echo "success";