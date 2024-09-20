<?php
class Solution{

    public function displayArrayItemsBatch($array,$limit= 5){

        $total = count($array);
        $batches = array_chunk($array, $limit); // Split the array into batches
        
        foreach ($batches as $batchNumber => $batch) {
            echo "Processing Batch " . ($batchNumber + 1) . ":\n";          
            foreach ($batch as $key=>$val) {
                    print("Key: ".$key." Val: ".$val."\n");    
            }
            
    
        }

 
    }
}

#test case
$test = new Solution();
$arr = range(1,20);
//$arr = [1,5,6,8,6,9,6,3,8,6];
$test->displayArrayItemsBatch($arr);
?>