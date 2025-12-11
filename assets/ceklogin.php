<?php
include 'koneksi.php';

session_start();

$auth = $_POST['auth'];
$user = $_POST['user'];
$pasw = $_POST['pasw'];


$sql = "SELECT id, auth, user, pasw FROM user_list WHERE auth='$auth' AND user='$user' AND pasw='$pasw' AND activ='1' AND flag='1'";
$result = $conn->query($sql);



if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
     $_SESSION["iduser"] = $row["id"];

    // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    header("Location: ../main.php");
  }
} else {
  echo "<script>alert('Anda tidak punya akses ke sistem');</script>";
  header("Location: ../index.php");

}
$conn->close();
?>