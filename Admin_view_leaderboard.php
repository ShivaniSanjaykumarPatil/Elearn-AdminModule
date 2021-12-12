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
		<ul>
		  <li><a href="Admin_view_scheduled_courses.php">View Scheduled Courses</a></li>
		  <li><a href="Admin_schedule_new_training.php">Schedule New Training</a></li>
		  <li><a href="Admin_generate_assessment_reports.php">Generate Assessment Reports</a></li>
		  <li><a class="active" href="Admin_view_leaderboard.php">View Leaderboard</a></li>
		  <li><a href="p5.html">Add New Trainer</a></li>
		</ul>
	</div>
	<div id="content">
			<h2 style="margin-left:20px;">Score point</h2>
			<form>
			<div id="filter" style="margin-left:200px;">
				Course Name&nbsp;&nbsp;&nbsp;&nbsp;<select>
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
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" name="SearchStudentName" placeholder="&#128269; Enter the student name" style="border-radius:20px; font-family:Arial,FontAwesome 5 free" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="Search" value="Search"style="width:200px; padding:5px; font-size:15px; color:white;background-color:blue; border-radius: 5px; border-color:#04AA6D"/>
			<p></p>
			</div>		
				<?php
						if (include_once('connection.php'))
						{
							$sql = "select dt.rank_no, dt.student_email,dt.sum_of_marks, dt.count_students from (select sum(marks_secured) as sum_of_marks, student_email,count(student_email) as count_students, RANK() OVER(ORDER BY sum(marks_secured)desc) as rank_no from enrolled_courses GROUP BY student_email order by sum(marks_secured)) as dt ";
							$res=mysqli_query($con, $sql);
							echo "<table id='tab' style='text-align:center; position:relative; left:100px;'>";
							echo "<thead id='thead'>";
							echo "<th>Rank</th>";
							echo "<th>Student name</th>";
							echo "<th>Score</th>";
							echo "<th>Assessments Attended</th>";
							echo "<thead>";
						while ($row = mysqli_fetch_row($res)) 
						{
							$a=explode("@",$row[2]);
                            $row[2]=$a[0];
							echo "<tr>";
							echo "<td>" . $row[0] . "</td>";
							echo "<td>" . $row[1] . "</td>";
							echo "<td>" . $row[2] . "</td>";
							echo "<td>" . $row[3] . "</td>";
							echo "</tr>";
						}
						echo "</table>";
						mysqli_close($con);
						}
					?>
			</form>
	</div>
</body>
</html>