<?php
   
   // 
   //   in: data file path(done), day range(done), attr, key, no of line per page, page no
   //   out: records
   //
   
   $j=0;
   $datafilepath='datafile/';
   $filedate = $_REQUEST['filedate'];
   $dayrange = 2;
   $attr = $_REQUEST['attr'];

   if (!isset($_REQUEST['key'])) {
      echo "Search key not found";
      throw new Exception('Search key not found'); 
   } else {
      $key = $_REQUEST['key'];
   }

   if (!isset($_REQUEST['attr']))
      $pattern = "/^".$key."/";
   else
      $pattern = "/".$key."/";
   
   
   $files = glob("datafile/".$filedate."*gz", GLOB_BRACE);
   if (!isset($_REQUEST['filedate']) || !$files) { 
      echo "Data file not found";
      throw new Exception('Data file not found'); 
   } else {
      foreach($files as $file) {
      $fp = gzopen($file, 'r');
   
      while ( !feof($fp) )
      {
          $line = fgets($fp, 2048);
   
          $delimiter = "\t";
          $data = str_getcsv($line, $delimiter);
   

//          preg_match($pattern, $line, $matches, PREG_OFFSET_CAPTURE, 3);

          if (preg_match($pattern,$line)) {
             $result[$j++] = $line;
          }

      }                              
   
      gzclose($fp);
      }
   
   }
   
   // Output 
   if (isset($_REQUEST['output']))
     switch ($_REQUEST['output']) {
       case 0: 
        echo json_encode($result,JSON_PRETTY_PRINT);
       default: 
         var_dump($result);
     }
    else
      var_dump($result);
   
php?>
