<head>
    <meta name="viewport" content="width=device-width, initial-scale=0.6 user-scalable=no">
</head>
<?php
include '../includes/connection.php';
include '../includes/tsidebar.php';
?><?php

$users = $_SESSION['users'];
$typid = $_SESSION['typid'];
$ID = $_SESSION['id'];
$name1 = $_SESSION['fname'];
$name2 = $_SESSION['lname'];
?>
<div class="card-body padding-top:200px">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <p>Dear <?php echo "$name1 $name2  your Department Infromation is : "; ?></p>
                <tr>
                    <th>DEPARTMENT ID</th>
                    <th>DEPARTMENT NAME</th>

                </tr>
            </thead>
            <tbody>
                <?php
$uemail = $_SESSION['email'];

$query = "SELECT employee.employeeID, employee.depertmentID, employee.email ,department.depertmentID,department.dName from employee left join department on department.depertmentID=employee.depertmentID WHERE employee.email='$uemail'";
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['depertmentID'] . '</td>';
    echo '<td>' . $row['dName'] . '</td>';

    echo '</tr> ';
}
?>
            </tbody>
        </table>
    </div>
</div>
</div>