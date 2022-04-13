<?php

//include libraries
include 'php-random-name-generator/randomNameGenerator.php';

ini_set('max_execution_time', '300');



class User extends Dbh{

    private $email;
    private $password;
    private $name;
    private $dob;




    //Add candidate to Applicants Database
    public static function apply(int $time, string $cid, string $name, string $email, string $resume){
              
        $sql = "INSERT INTO applicants (time, campaign_id, name, email, resume, status) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $bool = false;

        try {
            //code...
            $stmt = self::connect()->prepare($sql);
            $stmt->execute([$time, $cid, $name, $email, $resume,'pending']);
            $bool = true;
            //echo 'Did it work?';
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            $bool = false;
        }
        
        return $bool;
    }

    public function addCampaign(string $title, string $emp_type, int $companyid, string $overview, string $duties, string $requirements, string $keywords, int $date_added){
        $sql = "INSERT INTO campaigns (title, emp_type, companyid, overview, duties, requirements, keywords, date_added) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $bool = false;

        try {
            //code...
            $stmt = self::connect()->prepare($sql);
            $stmt->execute([$title, $emp_type, $companyid, $overview, $duties, $requirements, $keywords, $date_added]);

            $bool = true;
            echo 'Did it work?';
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            $bool = false;
        }

        return $bool;
    }

    public function generateCandidates(int $cid, int $size){

        $records = null;
        $row = 1;

        //read .csv file
        if (($handle = fopen("LargeDataset.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                   // echo $data[$c] . "<br/><br/><br/>";
                }
                
                if(is_null($records)){
                    $records = $data;
                }
                else
                    array_push($records, $data);
            }
            fclose($handle);
        }

        //Initialise Name Generator
        $r = new randomNameGenerator('array');
        $names = $r->generateNames($size);


        //pick random candidates
        for($i = 0; $i<$size; $i++){
            $randomNum = mt_rand(1,900);

            //get name
            //echo '<br/> Name: ' . $names[$i] . '<br/> Data: ' . $records[$randomNum][0] . ' '. $records[$randomNum][1] .'<br/><br/>';
           
            //get email
            $str = explode(" ",$names[$i]);
            $email = $str[0] .".".$str[1] ."@gmail.com";

            //get time
            $time = strtotime("now") + $i;

            
            //insert candidates into table
            if(!self::apply($time, $cid, $names[$i], $email, $records[$randomNum][1]))
                return false;

        }

        return true;

    }

    public function getApplicants(int $cid){

        $sql = "SELECT name FROM applicants WHERE campaign_id=?";
        $names = array();

        try {
            //code...
            $stmt = self::connect()->prepare($sql);
            $stmt->execute([$cid]);

            //print all applicants
            while($row = $stmt->fetch()){
                
                /*
                if(is_null($records)){
                    $records = $row;
                }
                else
                    array_push($records, $row);
                */

                $names[] = $row["name"];

            }

        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            
        }
        
        //print_r($records);

        return $names;
    }

    public function getCampaignsLimited(int $companyid){

        $sql = "SELECT * FROM campaigns WHERE companyid=? ORDER BY date_added DESC LIMIT 2";
        $campaigns = array();

        try {
            //code...
            $stmt = self::connect()->prepare($sql);
            $stmt->execute([$companyid]); //value for prepared statement
            $stmt->setFetchMode(PDO::FETCH_ASSOC);  //prints only an assoc array
            //print all applicants
            while($row = $stmt->fetch()){
                
                /*
                if(is_null($records)){
                    $records = $row;
                }
                else
                    array_push($records, $row);
                */

                $campaigns[] = $row;

            }

        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            
        }
        
        return $campaigns;
    }

    public function predict(string $model, int $cid){

        if($model == "CS"){
            //echo "Running Cosine Similarity Algorithm from Python and campaign ".$cid.'<br/><br/>';
            //$command = escapeshellcmd("python Python/test.py ");
            //$command = escapeshellcmd('python Python/cosinesimilarity.py '.$cid);
            $command = escapeshellcmd('python Python/cosinesimilarity.py '.$cid);
            $output = shell_exec($command);
                    
            //print the output from the python script
            //echo $output;
            //echo '<br/>JSON Output: '.json_decode($output, true);

            return $output;
        }
        elseif($model == "KNN"){
            $command = escapeshellcmd('python Python/knn.py '.$cid);
            $output = shell_exec($command);
                    
            //print the output from the python script
            //echo $output;
            //echo '<br/>JSON Output from KNN: '.json_decode($output, true);

            return $output;
        }

    }
}


?>