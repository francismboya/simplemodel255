<?php
require '../includes/connection.php';
require 'session.php';
$kind = 0;

?>

<?php
if (isset($_POST['user']) && isset($_POST['password'])) {
    $users = trim($_POST['user']);
    $upass = trim($_POST['password']);
    //$h_upass = sha1($upass);
    $h_upass = $upass;
    if ($upass == '') {
        echo json_encode(['status' => 'password']);
        exit();
        ?>

<?php
} else {
//create some sql statement
        $sql = "select login.email,
        login.password, employee.employeeID,
        employee.fname as efname,
         employee.mname as emname,
         employee.lname as elname,
         employee.email as eemail,
         employee.gender as egender,
         employee.file as efile,
         employee.depertmentID as edepertmentID,
         employee.phoneno as ephoneno,
         status.statusID,
         status.lstate,
         status.statusName, status.email,
         student.regno, student.fname,
          student.mname, student.lname,
          student.depertmentID,
          student.programID, student.year,
          student.level,
          student.email,
          student.file,
          student.gender,
          student.state,
          student.regDate,
         student.phoneno FROM login
        LEFT JOIN employee ON login.email=employee.email LEFT JOIN status on login.email=status.email
        LEFT JOIN student ON login.email=student.email
         where login.password='" . $h_upass . "' AND login.email='" . $users . "'";
        $result = $db->query($sql);
        if ($result) {
            //get the number of results based n the sql statement
            //check the number of result, if equal to one
            //IF theres a result
            if ($result->num_rows > 0) {
                //store the result to a array and passed to variable found_user
                $found_user = mysqli_fetch_array($result);
                //fill the result to session variable
                if ($found_user['statusName'] == "student") {
                    $_SESSION['ID'] = $found_user['regno'];
                    $_SESSION['fname'] = $found_user['fname'];
                    $_SESSION['mname'] = $found_user['mname'];
                    $_SESSION['lname'] = $found_user['lname'];
                    $_SESSION['depertmentID'] = $found_user['depertmentID'];
                    $_SESSION['programID'] = $found_user['programID'];
                    $_SESSION['year'] = $found_user['year'];
                    $_SESSION['level'] = $found_user['level'];
                    $_SESSION['email'] = $found_user['email'];
                    $_SESSION['file'] = $found_user['file'];
                    $_SESSION['state'] = $found_user['state'];
                    $_SESSION['regDate'] = $found_user['regDate'];
                    $_SESSION['phoneno'] = $found_user['phoneno'];
                    $_SESSION['statusName'] = $found_user['statusName'];
                    $_SESSION['gender'] = $found_user['gender'];
                    $_SESSION['key'] = date('dmYHis') . "francis&kweka";
                    $AAA = $_SESSION['ID'];
                    $_SESSION['users'] = "student";
                    $_SESSION['typid'] = "student.regno";
                    $_SESSION['id'] = "regno";
                } elseif ($found_user['statusName'] == "teacher" or $found_user['statusName'] == "admin" or $found_user['statusName'] == "hod"
                    or $found_user['statusName'] == "management" or $found_user['statusName'] == "registrar"
                    or $found_user['statusName'] == "principal") {
                    $_SESSION['ID'] = $found_user['employeeID'];
                    $_SESSION['fname'] = $found_user['efname'];
                    $_SESSION['mname'] = $found_user['emname'];
                    $_SESSION['lname'] = $found_user['elname'];
                    $_SESSION['depertmentID'] = $found_user['edepertmentID'];
                    $_SESSION['email'] = $found_user['eemail'];
                    $_SESSION['phoneno'] = $found_user['ephoneno'];
                    $_SESSION['statusName'] = $found_user['statusName'];
                    $_SESSION['gender'] = $found_user['egender'];
                    $_SESSION['file'] = $found_user['efile'];
                    $AAA = $_SESSION['ID'];
                    $_SESSION['key'] = date('dmYHis') . "francis&kweka";

                    $_SESSION['users'] = "employee";
                    $_SESSION['typid'] = "employee.employeeID";
                    $_SESSION['id'] = "employeeID";
                }

                if ($_SESSION['statusName'] == 'admin') {
                    $kind = 1;

                    ?>
<?php
} elseif ($_SESSION['statusName'] == 'teacher') {
                    $kind = 2;

                    ?>
<?php
} elseif ($_SESSION['statusName'] == 'student') {
                    $kind = 3;
                    ?>
<?php

                } elseif ($_SESSION['statusName'] == 'principal') {
                    $kind = 4;
                    ?>

<?php
} elseif ($_SESSION['statusName'] == 'registrar') {
                    $kind = 5;
                    ?>

<?php

                } elseif ($_SESSION['statusName'] == 'hod') {
                    $kind = 8;
                    ?>

<?php
}
            } else {
                $kind = 6;
                ?>

<?php

                // echo json_encode(['status' => 'password']);

            }

        } else {
            $kind = 7;
            # code...
            echo "Error: " . $sql . "<br>" . $db->error;
        }

    }
}

echo json_encode(['status' => $kind]);

//$db->close();

?>