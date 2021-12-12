<?php session_start(); ?>
<?php
if(isset($_POST['Add']))
{
$email=$_POST["email"];
$phone=$_POST["phone"];
$exp=$_POST["exp"];
$opt=$_POST["opt"];
if($email!='' or $phone!='' or $exp!='')
{
if(preg_match("/^([a-z]+)(([\.]?[a-z])*){5,20}@elearn.com$/",$email))
{
if(preg_match("/^[1-9][0-9]{9}$/",$phone))
{
if(preg_match("/^[1-9]+\.[0-9]{1}$/",$exp))
{
if($opt!="0")
{
include('connection.php');
$sql = "SELECT add_trainer('$email','$phone','$exp','$opt')";
$r= mysqli_query($con,$sql);
$res=mysqli_fetch_row($r);
$res=$res[0];
if($res=='1')
{
echo "<script>alert('The trainer already exists!')</script>";	
}
else if($res=='2')
{
echo "<script>alert('Trainer added successfully!')</script>";
}
mysqli_close($con);
}
else
{
echo "<script>alert('Select at least one skill for the trainer!')</script>";
}
}
else
{
echo "<script>alert('Please enter a valid experience!')</script>";
}
}
else
{
echo "<script>alert('Please enter a valid phone number!')</script>";
}
}
else
{
echo "<script>alert('Please enter a valid email!')</script>";
}
}
else
{
echo "<script>alert('Please fill all the fields!')</script>";
}
}
?>
