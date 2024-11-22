<?php
// cros
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

session_start(); 

// variabel data awal
$host = 'localhost';
$user = 'root';
$pw = '';
$dataBase = 'youtube';

// memulai koneksi
$connect_data = new mysqli($host, $user, $pw, $dataBase);

// cek koneksi
if ($connect_data->connect_error ) {
    // variabel ke java script
    $error_message = $connect_data->connect_error;
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '". addslashes($error_message) ."',
              footer: '<a href=\"#\">Why do I have this issue?</a>'
            });
          </script>";
          exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // DATA USER
    $emailUser = $_POST['email1'];
    $userPass = $_POST['password1'];

    // jika di cek maka akan di validasi dengan sqlcode
    // stmt = statment
    $stmt = $connect_data->prepare("SELECT * FROM user_admin WHERE email = ? AND password = ?");

    if ($stmt === false) {
        die("Error : " . $connect_data->error);
    }

    $stmt->bind_param('ss', $emailUser, $userPass); // sss = string
    $stmt->execute(); 
    $hasil = $stmt ->get_result(); // mengambil nilai hasil 
    
    if ($hasil->num_rows > 0) {
        // jikas user valid maka akan di arahkan ke sini
        echo "user valid";
        if (isset($_POST['Remember'])) {
            setcookie('user', $emailUser, time() + 60 * 60 * 24 * 30);
        }

        header("Location: ../../index.html"); // arahkan ke halaman index
        exit(); // clouse code
    } 
    else {
        // jika tidak valid maka akan di arahkan kesini
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                Swal.fire({
                  icon: 'error',
                  title: 'Login Failed',
                  text: 'Invalid email or password.'
                });
              </script>";
        exit();
    }

    // end
    $stmt->close();
}
// untuk mengakhiri stetment
$connect_data->close();
?>