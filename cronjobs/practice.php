<?php
require __DIR__. "/config.php";
$query = "select * from practice_exam_session where (status <> 'Completed' or status is NULL)";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_assoc($result)){
    $id = $row['id'];
    $start_time = date("Y-m-d H:i:s");
    $end_time = $row['end_time'];
    #echo $start_time." ".$end_time."\n";
    $start_datetime = new DateTime($start_time); 
    $diff = $start_datetime->diff(new DateTime($end_time)); 
    $time_remaining = ($diff->h)*60 + $diff->i; 
    $total_minutes = $time_remaining;
    $total_seconds = $diff->s;
    if(new DateTime() > new DateTime($end_time)){
        $time_remaining = 0;    
    }
    #echo $time_remaining."\n";
    if($time_remaining == 0){
		$update = "update practice_exam_session set status = 'Completed' where id=$id";
		mysqli_query($con, $update);
    }
}
mysqli_free_result($result);
mysqli_close($con);