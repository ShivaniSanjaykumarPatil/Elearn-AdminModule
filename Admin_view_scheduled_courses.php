<?php session_start(); ?>
<!DOCTYPE html>
<?php
if(isset($_POST['edit']))
{
if(isset($_POST['course']))
{
$a=$_POST['course'];
setcookie('cookie',$a,time() +2*24*60*60);
header("Location:p11.php");
}
else
{
echo "<script>alert('Please select a course to edit!')</script>";
}
}
if(isset($_POST['delete']))
{
if(isset($_POST['course']))
{
$a=$_POST['course'];
$a=explode('@',$a);
include_once('connection.php');
$sql2= " delete s from scheduled_courses s inner join course_details c on s.course_id=c.course_id where course_name='$a[0]' and start_date='$a[1]';";
$sql1= "delete s from enrolled_courses s inner join course_details c on s.course_id=c.course_id where course_name='$a[0]' and start_date='$a[1]'";
$res=mysqli_query($con,$sql1);
$res1=mysqli_query($con,$sql2);
mysqli_close($con);
echo "<script>alert('Course cancelled successfully!')</script>";
header("Location:p1.php");
}
else
{
echo "<script>alert('Please select a course to delete!')</script>";
}
}
?>
<html>
    <head>
        <link rel="stylesheet" href="s1.css">
                <style>
                                ul {
                                  list-style-type: none;
                                  margin: 0;
                                  padding: 0;
                                  width: 200px;
                                  height: 600px;
                                  background-color: #f1f1f1;

                                }
                                li{
                                        border-bottom: 1px solid #555;
                                }

                                li a {
                                  display: block;
                                  color: #000;
                                  padding: 8px 16px;
                                  text-decoration: none;
                                }

                                li a.active {
                                  background-color: #04AA6D;
                                  color: white;
                                }

                                li a:hover:not(.active) {
                                  background-color: #555;
                                  color: white;

                                }
								span > div
								{
								width:35px;
								height:5px;
								background-color:black;
								margin:6px 0;
								}
								.logout
								{
								
								}
								.nav:hover
								{
								display: block;
								}
                </style>

        </head>
<body style="background: #e3f1f1;">
        <div id="header"> E-Learning 
	<span style="position:relative;left:910px;"> <?php echo $_SESSION['Admin']; ?>
	<span style="position:absolute;left:150px;" class="nav" ><div></div><div></div><div></div>
	</span>
	</span>
	</div>
        <div>
                <ul>
                  <li><a class="active" href="p1.php">View Scheduled Courses</a></li>
                  <li><a href="p2.php">Schedule New Training</a></li>
                  <li><a href="p3.php">Generate Assessment Reports</a></li>
                  <li><a href="p4.php">View Leaderboard</a></li>
                  <li><a href="p5.html">Add New Trainer</a></li>
                </ul>
        </div>
        <div id="content">
		<a href="logout.php" style="background: White;margin-left:1000px;font-size:30px;" class="logout">logout</a>
                <div>
                        <h2 style="margin-left:20px;">Scheduled Courses</h2>
                        <form action="" method="post">
                                        <?php
                                                if (include_once('connection.php'))
                                                {
                                                        $sql = "SELECT course_name,start_date,end_date,assessment_status,trainer_email,participant_limit 
														FROM scheduled_courses s inner join course_details c on s.course_id=c.course_id";
                                                        $res=mysqli_query($con, $sql);
                                                        echo "<table id='tab' style='text-align:center; position:relative; left:100px;'>";
                                                        echo "<thead id='thead'>";
                                                        echo "<th>Select</th>";
                                                        echo "<th>Course Name</th>";
                                                        echo "<th>Start date</th>";
                                                        echo "<th>End date</th>";
                                                        echo "<th>Assessment status</th>";
                                                        echo "<th>Trainer name</th>";
                                                        echo "<th>Seat Availablity</th>";
                                                        echo "<thead>";
                                                while ($row = mysqli_fetch_row($res))
                                                {
                                                        $a=explode("@",$row[4]);
                                                        $row[4]=$a[0];
														$temp=$row[0].'@'.$row[1];
                                                        if ($row[1]<date("Y-m-d") && $row[2]<date("Y-m-d"))
                                                        {$row[5]="Completed";}
                                                        else if ($row[1]<date("Y-m-d"))
                                                        {$row[5]="In Progress";}
                                                        else
                                                        {
                                                                echo '';
														}
                                                        echo "<tr>";
                                                        echo "<td><input type='radio' name='course' value='$temp'></td>";
                                                        echo "<td>" . $row[0] . "</td>";
                                                        echo "<td>" . $row[1] . "</td>";
                                                        echo "<td>" . $row[2] . "</td>";
                                                        echo "<td>" . $row[3] . "</td>";
                                                        echo "<td>" . $row[4] . "</td>";
                                                        echo "<td>" . $row[5] . "</td>";
                                                        echo "</tr>";
                                                }
                                                echo "</table>";
                                                mysqli_close($con);
                                                }
										?>
                                <input type="submit" name="edit" value="edit" style="position:relative;left:400px;background: #FF8C00;" class="hb" id="b2">
                                <input type="submit" name="delete" value="delete" style="position:relative;left:500px;" class="hb" id="b2">
                </form>
                </div>
        </div>

</body>
</html>
