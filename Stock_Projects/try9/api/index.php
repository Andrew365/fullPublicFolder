<?php
$check  = $_GET['check'];

if($check == md5(sha1("bruh"))){
    

$ticker = $_GET['ticker'];
require '../includes/dates.php';
if(!$ticker){
  echo '<script type="text/javascript">
  window.alert("That ticker doesnt exist");

  document.location.href = "../dashboard.php";
  </script>';
  return false;
}
$file = "http://real-chart.finance.yahoo.com/table.csv?s={$ticker}&d={$curMonth}&e={$curDay}&f={$curYear}&g=d&a={$fromMonth}&b={$fromDay}&c={$fromYear}&ignore=.csv";
$file_headers = @get_headers($file);
if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
echo '<script type="text/javascript">
window.alert("That ticker doesnt exist");

</script>';
    return false;
}function createURL($ticker)
{

require '../includes/dates.php';

    $file = "http://real-chart.finance.yahoo.com/table.csv?s={$ticker}&d={$curMonth}&e={$curDay}&f={$curYear}&g=d&a={$fromMonth}&b={$fromDay}&c={$fromYear}&ignore=.csv";
    return $file;
}


function getCsvFile($url, $outputFile)
{

    $content = file_get_contents($url);
    $content = str_replace("Date,Open,High,Low,Close,Volume,Adj Close", "", $content);
    $content = trim($content);

    file_put_contents($outputFile, $content);
}

function fileToDatabase($txtfile, $tablename)
{

    $file = fopen($txtfile, "r");

    while (!feof($file)) {
        $line   = fgets($file);
        $pieces = explode(",", $line);

        $date   = $pieces[0];
        $open   = $pieces[1];
        $high   = $pieces[2];
        $low    = $pieces[3];
        $close  = $pieces[4];
        $volume = $pieces[5];
        // $adj_close = $pieces[6];

        $change         = $close - $open;
        $percent_change = ($change / $open) * 100;

        createTable($tablename);

        $sql     = "SELECT * FROM {$tablename}";
        require '../includes/connect.php';
        $result  = mysqli_query($connect, $sql);


        //creates table if one doesnt exist
        if (!$result) {

            $sql3    = "INSERT INTO {$tablename} (date, open, high, low, close, volume, amount_change, percent_change)
        VALUES ('$date','$open','$high','$low','$close','$volume','$change','$percent_change')";
            $result3 = mysqli_query($connect, $sql3);

            ini_set('max_execution_time', 60); //300 seconds = 5 minutes

            if ($result3) {

            } else {
                echo '<br />' . "error with the database " . mysqli_error($connect);
            }
        } elseif ($result) {

            $sql3    = "INSERT IGNORE INTO {$tablename} (date, open, high, low, close, volume, amount_change, percent_change)
             VALUES ('$date','$open','$high','$low','$close','$volume','$change','$percent_change')";
            $result3 = mysqli_query($connect, $sql3);

            ini_set('max_execution_time', 60); //300 seconds = 5 minutes

            if ($result3) {

            } else {
                echo '<br />' . "error with the database " . mysqli_error($connect);
            }

        }
    }
    fclose($file);
}



function createTable($tablename){
  require '../includes/connect.php';

      $companyTicker = $_GET['ticker'];

      $sql2    = "CREATE TABLE IF NOT EXISTS {$companyTicker}(date DATE,
          PRIMARY KEY(date),
          open FLOAT, high FLOAT,
           low FLOAT, close FLOAT,
            volume INT, amount_change FLOAT,
            percent_change FLOAT )";
      $result2 = mysqli_query($connect, $sql2);
      if($result2){

      }else{
        echo mysqli_error($connect);
          return false;
      }


}

function main()
{





        $companyTicker = $_GET['ticker'];
        $fileURL         = createURL($companyTicker);
        $companyTextFile = "../TextFiles/" . $companyTicker . ".txt";

      $file =  getCsvFile($fileURL, $companyTextFile);

        fileToDatabase($companyTextFile, $companyTicker);
    


}
main();//download data and put it into its own ticker table

//ALL GOOD HERE//










//analyze data with analsis a
function masterLoop(){
    require '../includes/connect.php';

      $table_sql = "CREATE TABLE IF NOT EXISTS analysis_a (
                    ticker VARCHAR(8),
                    daysInc INTEGER,
                    pctOfDaysInc FLOAT,
                    avgIncPct FLOAT,
                    daysDec float,
                    pctOfDaysDec FLOAT,
                    avgDecPct FLOAT,
                    BuyValue FLOAT,
                    SellValue FLOAT
                     )";
      $table = mysqli_query($connect, $table_sql);
      if(!$table){
        echo 'cant create table' . mysqli_error($connect);
      }
    
      $ticker = $_GET['ticker'];


        $nextDayIncrease = 0;
        $nextDayDecrease = 0;
        $nextDayNoChange = 0;

        $sumOfIncreases = 0;
        $sumOfDecreases = 0;

        $total = 0;
        $ltotal =0;



        $sql = "SELECT date, amount_change, percent_change, open, close, high, low  FROM {$ticker}"; //WHERE percent_change < '0' ORDER BY date AS ASC";
        $data = mysqli_query($connect, $sql);

    
        if($data){
            
            
                            
                //get formated current date
                        require '../includes/dates.php';
                $lastYear = $curYear -1;
                if($rcurMonth < 10){
                    if($curDay <10){
                        $curDate = "{$curYear}-0{$rcurMonth}-0{$curDay}";
                        $lastYearD = "{$lastYear}-0{$rcurMonth}-0{$curDay}";
                    }else{
                        $curDate = "{$curYear}-0{$rcurMonth}-{$curDay}";
                        $lastYearD = "{$lastYear}-0{$rcurMonth}-{$curDay}";
                    }
                }else{
                    if($curDay <10){
                        $curDate = "{$curYear}-{$rcurMonth}-0{$curDay}";
                        $lastYearD = "{$lastYear}-{$rcurMonth}-0{$curDay}";
                    }else{
                        $curDate = "{$curYear}-{$rcurMonth}-{$curDay}";
                        $lastYearD = "{$lastYear}-{$rcurMonth}-{$curDay}";
                    }
                }
                //end of get formatted date
                
                $l_sql = "SELECT open, close, high, low FROM {$ticker} WHERE date > '$lastYearD'";
                $l_res = mysqli_query($connect, $l_sql);
                if(!$l_res){
                 echo "this prolem";   
                }
            $avgTotal = 0;
                while($row3 = mysqli_fetch_array($l_res)){
                 
                    $lopen = $row3[0];
                    $lclose = $row3[1];
                    $lhigh = $row3[2];
                    $llow = $row3[3];
                    $lavgPrice1 = ($lopen + $lclose + $lhigh + $llow);
                    $avgTotal += $lavgPrice1;
                    $ltotal++;
                    
                }
                

                
            
            
            $avgPrice = 0;
            $lavgPrice1 = 0;

            //loop through data
            while($row = mysqli_fetch_array($data)){

                   //all analytics in here
                    //deep buy analysis
                
            
                
                $date = $row['date'];
                

                
                
                
                
                
            
                    $open = $row[2];
                    $close = $row[3];
                    $high = $row[4];
                    $low = $row[5];
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                    
                $percent_change = $row['percent_change'];
                $sql2 = "SELECT date, percent_change FROM {$ticker} WHERE date > {$date} ORDER BY date ASC LIMIT 1";

                $data2 = mysqli_query($connect, $sql2);
                $numberOfRows = mysqli_num_rows($data2);
                    $avgPrice = ($open + $close + $high + $low);

                if($numberOfRows == 1) {
                    //all analytics in here
                    //deep buy analysis

                    $row2 = mysqli_fetch_row($data2);
                    
                    $Buy = 1;
                    $Sell = 0;
                    
                    
                    
                    
                    $tom_date = $row2[0];
                    $tom_percent_change = $row[1];

                    if ($tom_percent_change > 0) {
                        $nextDayIncrease ++;
                        $sumOfIncreases += $tom_percent_change;

                        $total++;
                    } elseif ($tom_percent_change < 0) {
                        $total++;
                        $nextDayDecrease++;
                        $sumOfDecreases += $tom_percent_change;

                        $total++;
                    } else {
                        $nextDayNoChange++;
                        $total = 0;
                        $total++;
                    }
                    
                }elseif($numberOfRows==0){
                    //no more data after today
                }else{
                    echo "you have an error in analysis_a";
                }
 
                //if buy = 1 buy = yes and so on
            }//end of loop
            
        }
        else{
            echo "unable to select blah {$ticker} <br />" .  mysqli_error($connect);
            //we are ending up here
        }
        $nextDayIncreasePercent = ($nextDayIncrease/$total) * 100;
        $nextDayDecreasePercent = ($nextDayDecrease/$total) * 100;
        $lavgPrice1 = ($lopen + $lclose + $lhigh + $llow);

        $averageIncreasePercent = 0;
        $averageDecreasePercent = 0;
    
        $BuyValue = $Buy;
        $SellValue = $Sell;
    
        $avgPrice = ($avgPrice/$total);
             $lavgPrice = ($avgTotal/$ltotal);
                


        insertIntoResultTable($ticker, $nextDayIncrease, $nextDayIncreasePercent, $avgPrice, $nextDayDecrease, $nextDayDecreasePercent, $averageDecreasePercent, $BuyValue, $SellValue);
    }




//insert data into the result table
function  insertIntoResultTable($ticker, $nextDayIncrease, $nextDayIncreasePercent, $averageIncreasePercent, $lavgPrice, $nextDayDecreasePercent, $averageDecreasePercent, $BuyValue, $SellValue){
    $ticker = $_GET['ticker'];
    require '../includes/connect.php';
    $table_sql = "CREATE TABLE IF NOT EXISTS analysis_a (
                  ticker VARCHAR(8),
                  daysInc INTEGER,
                  pctOfDaysInc FLOAT,
                  avgIncPct FLOAT,
                  daysDec float,
                  pctOfDaysDec FLOAT,
                  avgDecPct FLOAT,
                  BuyValue FLOAT,
                  SellValue FLOAT
                   )";
    $table = mysqli_query($connect, $table_sql);
    if(!$table){
      echo 'cant create table' . mysqli_error($connect);
    }


    $query="SELECT * FROM analysis_a WHERE ticker='$ticker' ";
    $result=mysqli_query($connect, $query);
    $numberOfRows = mysqli_num_rows($result);

    if($numberOfRows > 0 && $numberOfRows <2){
        $sql = "UPDATE analysis_a SET ticker='$ticker',daysInc='$nextDayIncrease',pctOfDaysInc='$nextDayIncreasePercent',avgIncPct='$averageIncreasePercent',daysDec='$nextDayDecrease',pctOfDaysDec='$nextDayDecreasePercent',avgDecPct='$averageDecreasePercent',BuyValue='$BuyValue',SellValue='$SellValue' WHERE ticker='$ticker' ";
        mysqli_query($connect, $sql);
        
    }
    elseif($numberOfRows > 1){

        
    }elseif($numberOfRows == 0){
        $sql="INSERT INTO analysis_a (ticker,daysInc,pctOfDaysInc,avgIncPct,daysDec,pctOfDaysDec,avgDecPct,BuyValue,SellValue) VALUES ('$ticker', '$nextDayIncrease', '$nextDayIncreasePercent', '$averageIncreasePercent', '$lavgPrice', '$nextDayDecreasePercent', '$averageDecreasePercent', '$BuyValue', '$SellValue')";
        mysqli_query($connect, $sql);
        if(!mysqli_query($connect, $sql)){
            echo "error here";
        }
        
    }

}
//call your function
masterLoop();
//END OF ANALYSIS A






//read data

  $sql = "SELECT ticker, daysInc, pctOfDaysInc, avgIncPct, daysDec, pctOfDaysDec, avgDecPct, BuyValue, SellValue FROM `analysis_a` WHERE ticker = '$ticker'";

    require '../includes/connect.php';
  $data = mysqli_query($connect, $sql);
     $row = mysqli_fetch_array($data);


    $i = 0;
    $ticker = $row['ticker'];
    $ticker = strtoupper($ticker);
    $daysInc = $row['daysInc'];
    $pctOfDaysInc = $row['pctOfDaysInc'];
    $avgPrice = $row['avgIncPct'];
    $lavgPrice = $row['daysDec'];
    $pctOfDaysDec = $row['pctOfDaysDec'];
    $topTrendLinePrice = $row['avgDecPct'];
    $BuyValue = $row['BuyValue'];
    $SellValue = $row['SellValue'];
    if($BuyValue == 1){
     $BuyValue = "yes";   
    }elseif($BuyValue == 0){
     $BuyValue = "no";   
    }

    
    
    

//Show data in index
$json = array(
    'ticker' => $ticker,
    'daysInc' => $daysInc,
    'pctOfDaysInc' => $pctOfDaysInc,
    'avgPrice' => $avgPrice,
    'topTrendLinePrice' => $lavgPrice,
    'pctOfDaysDec' => $pctOfDaysDec,
    'buy' => $BuyValue,
    'sell' => $SellValue
    );
echo json_encode($json);
}
else{
 echo "you cant see this";   
}