<?php

// 
//   in: data file path(done), day range(done), attr, key, no of line per page, page no
//   out: records
//

$j=0;
$datafilepath='datafile/';
$filedate = $_GET['filedate'];
$dayrange = 2;

$files = glob("datafile/".$filedate."*gz", GLOB_BRACE);
if (!$files) { echo "Data file not found"; }
else {
foreach($files as $file) {
$fp = gzopen($file, 'r');

while ( !feof($fp) )
{
    $line = fgets($fp, 2048);


    $delimiter = "\t";
    $data = str_getcsv($line, $delimiter);

    $result[$j++] = $data;
}                              

gzclose($fp);


}

}


/*

for ($i=0;$i<=$dayrange;$i++) {


$fp = fopen($datafilepath.$filedate, 'r');

while ( !feof($fp) )
{
    $line = fgets($fp, 2048);


    $delimiter = "\t";
    $data = str_getcsv($line, $delimiter);

    $result[$i] = $data;
}                              

fclose($fp);
}
*/

print_r($result);

php?>
