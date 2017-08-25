<?php

include 'conn.php';

session_start();

$id = $_POST['p_ref_id'];
$sub = $_POST['p_sub'];
$diary_no = $_POST['p_diary_num'];
$from_emp_id = $_POST['p_from_emp_id'];
$to_dept = $_POST['p_to_dept'];
$nop = $_POST['p_nop'];
$rmrk = $_POST['p_rmrk'];

#hop = 1;

$user = $_SESSION['user'];

$GLOBALS['info_flag'] = 1;
$GLOBALS['mvmt_flag'] = 1;

//From dept
$branch = mysqli_query($conn, "SELECT branch_name FROM login_details WHERE username = '$user'");
while ($row = mysqli_fetch_array($branch)) {
	$from_dept = $row['branch_name'];
}

//Calculation of the number of hops
$hop_row = mysqli_query($conn, "SELECT MAX(paper_hop_num) AS 'recent' FROM paper_movement WHERE paper_ref_id='$id'");

if(mysqli_num_rows($hop_row) > 0) 
{
	$row = mysqli_fetch_array($hop_row);
	$hop_value = $row['recent'];
	$hop_value++;
	$hop = $hop_value;
}
else
{
	$hop = 1;
}


// Setting the value of the flag denoting existence of the file in the table
$query = mysqli_query($conn, "SELECT paper_ref_id FROM paper_master_info WHERE paper_ref_id = '$id'");

if (mysqli_num_rows($query) > 0) {
	$exists = "true";
	insert_movement($conn,$id,$sub,$from_dept,$from_emp_id,$to_dept,$diary_no,$nop,$hop,$rmrk);
} else
{
	$exists = "false";
	insert_info($conn,$id,$sub,$diary_no);
	insert_movement($conn,$id,$sub,$from_dept,$from_emp_id,$to_dept,$diary_no,$nop,$hop,$rmrk);
}
//echo($exists);

if ($GLOBALS['info_flag'] ==1 && $GLOBALS['mvmt_flag'] ==1) {

	Print '<script>alert("You successfully sent the paper.");</script>'; 
	Print '<script>window.location.assign("index.html");</script>';
} else {
	Print '<script>alert("Paper sending failed. Please try again!");</script>'; 
	Print '<script>window.location.assign("send_paper_others.html");</script>';
}

function insert_info(&$conn,&$id,&$sub,&$diary_no) {
	

	$sql = "INSERT INTO paper_master_info(paper_ref_id, paper_subject, paper_diary_num) 
				VALUES ('$id','$sub','$diary_no')";
	$result = mysqli_query($conn,$sql);
	if (!$result) {

		$GLOBALS['info_flag'] = 0;
	} 
	else{
		
		$GLOBALS['info_flag'] = 1;
	}	
}

function insert_movement(&$conn,&$id,&$sub,&$from_dept,&$from_emp_id,&$to_dept,&$diary_no,&$nop,&$hop,&$rmrk) 
{
	$query = "UPDATE paper_master_info SET paper_hops='$hop' WHERE paper_ref_id ='$id'";
	$result = mysqli_query($conn,$query); 

	#$sql = "INSERT INTO paper_movement (paper_ref_id, paper_sub, paper_from_dept, paper_from_diary_num, paper_from_emp_id, paper_to_dept, paper_nop, paper_hop_num, paper_remarks) VALUES ('$id','$sub','$from_dept','$diary_no', '$from_emp_id','$to_dept','$nop','$hop','$rmrk')";
	//$sqli = "INSERT INTO `file_movement` (`file_ref_id`, `file_sub`, `file_from_dt`, `file_from_dept`, `file_from_emp_id`, `file_to_dt`, `file_to_dept`, `file_to_emp_id`, `file_nop`, `file_hop_num`, `file_remarks`) VALUES ('54657', 'hello', CURRENT_TIMESTAMP, 'DCP/T-North', '647', '2017-07-11', 'ACP', 'NULL', '7', '1', 'none')";

	/*$sql = "INSERT INTO paper_movement (`paper_ref_id`, `paper_sub`, `paper_from_dept`, `paper_from_emp_id`, `paper_to_dept`,`paper_dept_diary_num`, `paper_nop`, `paper_hop_num`, `paper_remarks`) 
	VALUES ('$id', '$sub', '$from_dept', '$from_emp_id', '$to_dept','$diary_no', '$nop', '$hop', '$rmrk')";
*/
	$sql = "INSERT INTO paper_movement (paper_ref_id, paper_subject, paper_from_dept, paper_from_emp_id, paper_to_dept,paper_dept_diary_num, paper_nop, paper_hop_num, paper_remarks) 
	VALUES ('$id', '$sub', '$from_dept', '$from_emp_id', '$to_dept','$diary_no', '$nop', '$hop', '$rmrk')";


	$result = mysqli_query($conn,$sql);
	if (!$result) {

	$GLOBALS['mvmt_flag'] = 0;
	}
	else
	{
	
		$GLOBALS['mvmt_flag'] = 1;
	}
}


mysqli_close($conn);

?>