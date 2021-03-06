<?php

include 'conn.php';

session_start();
$user = $_SESSION['user'];

$gen = mysqli_query($conn, "SELECT MAX(file_ref_id) as 'last' FROM file_master_info");

if(mysqli_num_rows($gen) > 0)
{
	$row = mysqli_fetch_array($gen);
	$id= $row['last'];
	$id++;
} 
$branch = mysqli_query($conn, "SELECT branch_code FROM login_details WHERE username = '$user'");
while ($row = mysqli_fetch_array($branch)) {
    $dept = $row['branch_code'];
}
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
    <link rel="shortcut icon" href="images/favicon.ico" /> 
	<title>Generate File Id</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>

	<link rel="stylesheet" href="assets/stylesheets/styles.css" />
</head>
<body>
	 <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <img src="images/dtp_logo.png" height="50px" width="180px" style="margin-left:10px;" align="center"> 

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
              <!--   <a class="navbar-brand" href="http://localhost:8000">DELHI TRAFFIC POLICE - Document Management System</a> -->
            </div>
            <!-- /.navbar-header -->

           <ul class="nav navbar-top-links navbar-right">
                
                <!-- /.dropdown -->
                <li class="dropdown">
                   <form action="logout.php" method="POST">
                    <button class="dropdown-toggle" data-toggle="dropdown" style="margin-top:0.5em">
                        <i class="fa fa-user fa-fw"></i> <i>Logout</i>
                    </button>
                </form>

                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <br>
                       <br>
                       <li></li>
                         <li>
                            <a href="index.html"><i class="fa fa-edit fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="send.html"><i class="fa fa-dashboard fa-fw"></i> Send </a>
                        </li>
                        <li>
                            <a href="receive.html"><i class="fa fa-bar-chart-o fa-fw"></i> Receive </a>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="search.html"><i class="fa fa-table fa-fw"></i> Search</a>
                        </li>
                       
                        <li>
                            <a href="#"><i class="fa fa-file-word-o fa-fw"></i> View Reports<span class="fa arrow"></span></a> </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
     
        <div class="col-sm-12">
            <div class="col-lg-4"></div>
            <div class="row">
            <br>
            <br>

<label>Generated File Id :</label>

<input type="text" value="<?php echo "DTP/".$dept."/".$id?>" readonly>
                
               
            </div> 
      
</div>
 
            </div>
    </div>
	<script src="http://localhost:8000/assets/scripts/frontend.js" type="text/javascript"></script>
</body>
</html>