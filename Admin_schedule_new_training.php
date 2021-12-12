<?php session_start(); ?>
<!DOCTYPE html>
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
								.nav ol li
								{
								display:none;
								}
								.nav:hover ol .dropdown li
								{
								background:white;
								display:block;
								}
								
                </style>

        </head>
<body style="background: #e3f1f1;">
        <div id="header"> E-Learning 
	<span style="position:relative;left:910px;"> <?php echo $_SESSION['Admin']; ?> 
	<span style="position:absolute;left:150px;" class="nav" ><div></div><div></div><div></div>
	<ol class="dropdown">
	<li >logout</li>
	</ol>
	</span>
	</span>
	</div>
        <div>
                <ul id="ui">
                  <li><a href="Admin_view_scheduled_courses.php">View Scheduled Courses</a></li>
                  <li><a class="active" href="Admin_schedule_new_training.php">Schedule New Training</a></li>
                  <li><a href="p3.php">Generate Assessment Reports</a></li>
                  <li><a href="p4.php">View Leaderboard</a></li>
                  <li><a href="p5.html">Add New Trainer</a></li>
                </ul>
        </div>
        
                <div id="content">

	
		<div style="position:relative;top:30px;left:100px;font-size:30px;"> Edit Course Schedule </div>
		<br>
		<div id="form">
			<form action=""  method="POST">
				<table >
					<tr>
						<td style="font-size:20px;"> Course Name </td>
						<td> 
						<select name="course" style="height:30px;width:310px">
						<?php
						include_once('connection.php');
						$sql = "SELECT course_name FROM course_details";
						$res=mysqli_query($con, $sql);
						while($row=mysqli_fetch_row($res))
						{
							echo "<option>".$row[0]."</option>";
						}
						?>
						</select>
						</td>
					</tr>
					<tr>
					</tr>
					<tr>
						<td style="font-size:20px;"> Start Date </td>
						<td> <input type="date" name="date" style="height:30px;width:305px" ></td>
					</tr>
					<tr>
					</tr>
					<tr>
						<td style="font-size:20px;"> Trainer Name </td>
						<td> 
						<select name="Trainer" style="height:30px;width:310px">
						<?php
						include_once('connection.php');
						$sql = "SELECT trainer_email FROM trainer_details";
						$res=mysqli_query($con, $sql);
						while($row=mysqli_fetch_row($res))
						{
							$a=explode("@",$row[0]);
                            $row[0]=$a[0];
							echo "<option>".$row[0]."</option>";
						}
						mysqli_close($con);
						?>
							</select>
						</td>
					</tr>
					<tr>
					</tr>
					<tr>
						<td style="font-size:20px;"> Participant Limit </td>
						<td> <input type="number" name="Limit" min="1" max="100" style="height:30px;width:300px" ></td>
					</tr>
					<tr>
					</tr>
					<tr>
						<td style="font-size:20px;"> Assessment </td>
						<td> 
						<select name="Assessment" style="height:30px;width:310px" >
								<option value="Yes" >Yes</option>
								<option value="No" selected>No</option>
							</select>
						</td>
					</tr>
					<tr>
					</tr>
					<tr>
						<td style="font-size:20px;"> No. Of. Questions </td>
						<td> 
						<input type='number' name='Questions' min='1' max='20' style='height:30px;width:300px'>
						</td>
					</tr>
					<tr>
					<td></td>
					</tr>
				</table>	
			<input type="submit" name="U" value="Update Schedule" style="font-size:20px;height:40px;width:200px" id="b1">
			<input type="reset" name="cancel" value="cancel" style="font-size:20px;height:40px;width:100px" id="b2">
<?php
if(isset($_POST['U']))
{
$course=$_POST['course'];
$date=$_POST['date'];
$Trainer=$_POST['Trainer'];

$Limit=$_POST['Limit'];
$Assessment=$_POST['Assessment'];
if($course!="" and $date!="" and $Trainer!="" and $Limit!="" and $Assessment!="")
{
if($date>date('Y-m-d',strtotime('+3 day')))
{
if($Limit>=0 && $Limit<=100)
{
if($Assessment=='Yes')
{
$Questions=$_POST['Questions'];
echo 0;
if($Questions>5)
{
$Trainer=$Trainer.'@elearn.com';
$schedule="schedule";
include_once('connection.php');
$call=mysqli_prepare($con,'call schedule_course(?,?,?,?,?,?,?,@status)');
		mysqli_stmt_bind_param($call,'sssisis',$course,$date,$Trainer,$Assessment,$Limit,$Questions,$schedule);
		mysqli_stmt_execute($call);
        $sql1= "select @status";
        $res=mysqli_query($con,$sql1);
        $row=mysqli_fetch_row($res);
        $a=$row[0];
		echo "<script>alert('$a')</script>";
mysqli_close($con);
}
else
{
echo "<script>alert('No. of Questions should be greater than 5!')</script>";
}
}
}
else
{
echo "<script>alert('Participant limit should be within 100!')</script>";
}
}
else
{
echo "<script>alert('Please choose a future date!')</script>";
}
}
else
{
echo "<script>alert('Please fill all the required fields!')</script>";
}
}
?>
			</form>
		</div>
		</div>

</body>
</html>

