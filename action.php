<!DOCTYPE HTML>
<html>

<body>


<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "rexx";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//getting json data
$jsondata = file_get_contents('events.json');
$data = json_decode($jsondata, true);

foreach ($data as $row) {
$participation_id = $row['participation_id']; 
$employee_name = $row['employee_name'];
$employee_mail = $row['employee_mail'];
$event_id = $row['event_id'];
$event_name = $row['event_name'];
$participation_fee = $row['participation_fee']; 
$event_date = $row['event_date']; 
//saving json data
$sql = "INSERT INTO events(participation_id, employee_name, employee_mail, event_id, event_name, participation_fee, event_date) VALUES('$participation_id', '$employee_name', '$employee_mail', '$event_id', '$event_name,', '$participation_fee', '$event_date')"; 
$conn->query($sql);
}
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<div>
<form action="action.php" method="post">
<table>
<td>
<select name="employee_name">
<option disabled selected>--- Select name---</option>
  

<?php

$query = mysqli_query($conn, "SELECT distinct employee_name FROM events ")
   or die (mysqli_error($conn));

while($data = mysqli_fetch_array($query))
        {
            echo "<option value='". $data['employee_name'] ."'>" .$data['employee_name'] ."</option>";  
        }   
    ?>  
    

</select></td>
<td>
    <select name="event_name">
<option disabled selected>--- Select event---</option>
  

<?php

$query = mysqli_query($conn, "SELECT distinct event_name FROM events ")
   or die (mysqli_error($conn));

while($data = mysqli_fetch_array($query))
        {
            echo "<option value='". $data['event_name'] ."'>" .$data['event_name'] ."</option>";  
        }   
    ?>  
</select></td>
<td>
    <select name="event_date">
<option disabled selected>--- Select date---</option>
  

<?php

$query = mysqli_query($conn, "SELECT distinct event_date FROM events ")
   or die (mysqli_error($conn));

while($data = mysqli_fetch_array($query))
        {
            echo "<option value='". $data['event_date'] ."'>" .$data['event_date'] ."</option>";  
        }   
    ?>  
</select></td>

<td>
<input type="submit" value="Filter"/></td></table>
</form>
</div>
<?php
$selectOption1 = $_POST['employee_name'];
$selectOption2 = $_POST['event_name'];
$selectOption3 = $_POST['event_date'];
$qry="";
if($selectOption1!='' || $selectOption2!='' || $selectOption3!='')
{
    //seeting up dynamic query for filters.
    $qry=" WHERE ";
    if($selectOption1!='')
    {
        if($qry==" WHERE ")
    $qry=$qry."employee_name='".$selectOption1."' ";
        else
    $qry=$qry."and employee_name='".$selectOption1."' ";

    }
    if($selectOption2!='')
    {
       
        if($qry==" WHERE ")
    $qry=$qry."event_name LIKE '%".$selectOption2."%' ";
        else
    $qry=$qry."and event_name LIKE '%".$selectOption2."%' ";
      
    }
    if($selectOption3!='')
    {
        if($qry==" WHERE ")
    $qry=$qry."event_date LIKE '%".$selectOption3."%' ";
        else
    $qry=$qry." and event_date LIKE '%".$selectOption3."%' ";

    }
}
?>

<hr>
<table id="events" border="1" align="center">
<tr>
  <th>PARTICIPATION ID</th>
  <th>EMPLOYEE NAME</th>
  <th>EMPLOYEE MAIL</th>
  <th>EVENT ID</th>
  <th>EVENT NAME</th>
  <th>PARTICIPATION FEE</th>
  <th>EVENT DATE</th>
 </tr>
<?php
$query = mysqli_query($conn, "SELECT participation_id,employee_name,employee_mail,event_id,event_name,participation_fee,event_date FROM events ".$qry)
   or die (mysqli_error($conn));
while ($row = mysqli_fetch_array($query)) {
  echo
   "<tr>
    <td>{$row['participation_id']}</td>
    <td>{$row['employee_name']}</td>
    <td>{$row['employee_mail']}</td>
    <td>{$row['event_id']}</td>
    <td>{$row['event_name']}</td>
    <td>{$row['participation_fee']}</td>
    <td>{$row['event_date']}</td>
    </tr>";

}
?>

<?php

$query = mysqli_query($conn, "SELECT SUM(participation_fee) as sums  FROM events ".$qry)
   or die (mysqli_error($conn));

while ($row = mysqli_fetch_array($query)) {
  echo
   "<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>{$row['sums']}</td>
    <td></td>
    </tr>";

}
?>
</table>
</body>
</html>

