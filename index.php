<?php
    include("config.php");
    session_start();
    session_unset();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (empty($_POST["email"]) && empty($_POST['password'])) {
            $error = "Por favor introduza o seu Email e Password!";
        } else if (empty($_POST["email"])) {
            $error = "Por favor introduza o seu Email!";
        } else if (empty($_POST["password"])) {
            $error = "Por favor introduza a sua Password!";
        } else {
            $email = mysqli_real_escape_string($mysqli, $_POST['email']);
            $password = mysqli_real_escape_string($mysqli, $_POST['password']);

            $options = [
                'cost' => 10,
            ];

            $sql = "SELECT id, password FROM user_login WHERE email = '".$email."'";
            $result = mysqli_query($mysqli, $sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

            // Se o valor retornado pela base de dados coincidir com $username e $password, o número de linhas será 1.
            if (mysqli_num_rows($result) === 1 && password_verify($password, $row['password'])) {
                $_SESSION['username'] = $email;
                header("Location: tables.php");
            } else {
                $error = "O Email ou a Password estão incorretos!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Custom favicon-->
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login de Administrador</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gray-900">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Login de Administrador</h1>
                            </div>
                            <form class="user" method="post">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user" id="email" aria-describedby="emailHelp" placeholder="Introduza o seu endereço de Email...">
                                </div>
                                <div class="form-group">
                                  <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Introduza a sua Password...">
                                </div>
                                <input class="btn btn-primary btn-user btn-block" type="submit" value="Login"/><br />
                            </form>
                            <hr>
<?php
    if ($error) {
        echo '<div class="alert alert-danger">'.$error.'</div>';
    }
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
