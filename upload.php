<?php
// include mysql database configuration file
include_once 'db.php';
 
if (isset($_POST['submit']))
{
 
    // Allowed mime types
    $fileMimes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );
 
    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes))
    {
 
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
 
            // Skip the first line
            fgetcsv($csvFile);
 
            // Parse data from CSV file line by line
             // Parse data from CSV file line by line
             $m = substr($_FILES["file"]["name"], 0, 10);
             $date = date("Y-m-d", strtotime($m));
             // die(date("Y-m-d", strtotime($m)));
             // die(json_encode($_FILES));
             // If user already exists in the database with the same email
             $query = $conn->prepare("select dates_id from nums where dates_id =:nm");

             $query->execute([":nm"=>$date]);
             // $check = ;
             $t = 0;
             foreach($query->fetchAll() as $x){
                 $t++;
             }
             
             if ($t > 0)
             {
                 die("Data exists");
             }
             else{
                $m = $conn->prepare("insert into dates set name=:nm");
                $m->execute([":nm"=>$date]);
                while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
                {
                    // Get row data
                    $name = $getData[0];
                    $e = $getData[1];
                    // $date = $_POST['date'];
                    // $status = $getData[3];
                    
                    {
                   
                    // if($t<0){
                        
                    // }
                   
                    $u  = $conn->prepare("INSERT INTO nums SET names=:n, loc_id=:lo, dates_id=:dates");
                    $u->execute([":n"=>$name, ":lo"=>$e, ":dates"=>$date]);
    
                }
            }
            }
 
            // Close opened CSV file
            fclose($csvFile);
 
            header("Location: /");
         
    }else{
        echo "Please select valid file";
    }
    
}
