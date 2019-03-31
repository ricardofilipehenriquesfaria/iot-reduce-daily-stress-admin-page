<?php
    include("config.php");
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (isset($_POST['Editar'])) {

            insertCivilProtectionTable(
                    $_POST['id'],
                    $_POST['name'],
                    $_POST['localizacao'],
                    $_POST['estado'],
                    $_POST['justificacao'],
                    $_POST['responsabilidade'],
                    $_POST['edital_documento'],
                    $_POST['coordenadas'],
                    $_POST['data_encerramento'],
                    $_POST['data_reabertura'],
                    $_POST['hora_encerramento'],
                    $_POST['hora_reabertura'],
                    $_POST['tipo_encerramento']);

            header("Location: tables.php");
        } else if (isset($_POST['Eliminar'])) {

            updateCivilProtectionTable($_POST['id_delete']);
            header("Location: tables.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <!-- Custom favicon-->
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Página de Administrador</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="tables.php">
                <div class="sidebar-brand-text mx-3">Tabelas</div>
            </a>
    
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
    
            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Dados da Proteção Civil</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>

                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrador</span>
                        <img class="img-profile rounded-circle" src="/img/favicon.png">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                             Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Dados da Proteção Civil</h1>
            <p class="mb-4">Os dados da Proteção Civil necessitam de ser normalizados de modo a poderem ser utilizados na plataforma.</p>

            <!-- DataTales -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabela</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <iframe name="votar" style="display:none;"></iframe>
                        <table class="table table- table-dark" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Ações</th>
                                    <th style="display:none;">Id</th>
                                    <th>Nome</th>
                                    <th>Localização</th>
                                    <th>Estado</th>
                                    <th style="display:none;">Justificação</th>
                                    <th style="display:none;">Responsabilidade</th>
                                    <th style="display:none;">Edital/Documento</th>
                                    <th style="display:none;">Coordenadas</th>
                                    <th>Data de Encerramento</th>
                                    <th>Data de Reabertura</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Ações</th>
                                    <th style="display:none;">Id</th>
                                    <th>Nome</th>
                                    <th>Localização</th>
                                    <th>Estado</th>
                                    <th style="display:none;">Justificação</th>
                                    <th style="display:none;">Responsabilidade</th>
                                    <th style="display:none;">Edital/Documento</th>
                                    <th style="display:none;">Coordenadas</th>
                                    <th>Data de Encerramento</th>
                                    <th>Data de Reabertura</th>
                                </tr>
                            </tfoot>
                            <tbody>
<?php
    $sql = "SELECT * FROM temp_civil_protection WHERE editado = 0";
    $result = mysqli_query($mysqli_closed_roads, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            echo "<form id=\"submit-form\" name=\"form\" method=\"post\" target=\"votar\">
                    <tr>
                        <td>
                            <div class=\"button-group \"> 
                                <button 
                                    type=\"submit\" 
                                    class=\"btn btn-block btn-success\" 
                                    data-toggle=\"modal\" 
                                    data-target=\"#editModal\"
                                    onClick=\"tables.setRow('"
                                        .utf8_encode($row['id'])."','"
                                        .utf8_encode($row['name'])."','"
                                        .utf8_encode($row['localizacao'])."','"
                                        .utf8_encode($row['estado'])."','"
                                        .utf8_encode($row['justificacao'])."','"
                                        .utf8_encode($row['responsabilidade'])."','"
                                        .utf8_encode($row['edital_documento'])."','"
                                        .utf8_encode($row['coordenadas'])."','"
                                        .utf8_encode($row['data_encerramento'])."','"
                                        .utf8_encode($row['data_reabertura']).
                                    "')\">
                                    Editar
                                </button>
                                <button type=\"submit\" class=\"btn btn-block btn-danger\" data-toggle=\"modal\" data-target='#deleteModal' onClick=\"tables.setDeleteRow('".utf8_encode($row['id'])."')\">Eliminar</button>
                            </div>
                        </td>
                        <td id=\"id".utf8_encode($row['id'])."\" style=\"display:none;\">".utf8_encode($row['id'])."</td>
                        <td id=\"name".utf8_encode($row['id'])."\">".utf8_encode($row['name'])."</td>
                        <td id=\"localizacao".utf8_encode($row['id'])."\">".utf8_encode($row['localizacao'])."</td>
                        <td id=\"estado".utf8_encode($row['id'])."\">".utf8_encode($row['estado'])."</td>
                        <td id=\"justificacao".utf8_encode($row['id'])."\" style=\"display:none;\">".utf8_encode($row['justificacao'])."</td>
                        <td id=\"responsabilidade".utf8_encode($row['id'])."\" style=\"display:none;\">".utf8_encode($row['responsabilidade'])."</td>
                        <td id=\"edital_documento".utf8_encode($row['id'])."\" style=\"display:none;\">".utf8_encode($row['edital_documento'])."</td>
                        <td id=\"coordenadas".utf8_encode($row['id'])."\" style=\"display:none;\">".utf8_encode($row['coordenadas'])."</td>
                        <td id=\"data_encerramento".utf8_encode($row['id'])."\">".utf8_encode($row['data_encerramento'])."</td>
                        <td id=\"data_reabertura".utf8_encode($row['id'])."\">".utf8_encode($row['data_reabertura'])."</td>
                    </tr>
                </form>";
        }
    }
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; IOT Reduce Daily Stress Application 2019</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tem a certeza de que pretende sair?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecione "Logout" para terminar a sessão atual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Registo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="needs-validation was-validated" method="post">
                    <div class="modal-body">
                        <div class="form-group" style="display:none;">
                            <label>ID</label>
                            <input type="input" class="form-control" id="id" name="id" />
                        </div>
                        <div class="form-group">
                            <label>Nome da Via</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Insira o nome da via..." required />
                            <div class="invalid-feedback">Por favor insira o nome da via.</div>
                        </div>
                        <div class="form-group">
                            <label>Localização</label>
                            <input type="text" class="form-control" id="localizacao" name="localizacao" placeholder="Insira a localização da via..." required />
                            <div class="invalid-feedback">Por favor insira a localização da via.</div>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" placeholder="Insira o estado da via..." required />
                            <div class="invalid-feedback">Por favor insira o estado da via.</div>
                        </div>
                        <div class="form-group">
                            <label>Justificação</label>
                            <input type="text" class="form-control" id="justificacao" name="justificacao" placeholder="Insira a justificação para o encerramento da via..." required />
                            <div class="invalid-feedback">Por favor insira a justificação para o encerramento da via.</div>
                        </div>
                        <div class="form-group">
                            <label>Responsabilidade</label>
                            <input type="text" class="form-control" id="responsabilidade" name="responsabilidade" placeholder="Insira a quem se deve a responsabilidade..." required />
                            <div class="invalid-feedback">Por favor insira a quem se deve a responsabilidade do encerramento da via.</div>
                        </div>
                        <div class="form-group">
                            <label>Edital/Documento</label>
                            <input type="text" class="form-control" id="edital_documento" name="edital_documento" placeholder="Insira o url para o Edital/Documento..." />
                        </div>
                        <div class="form-group" style="display:none;">
                            <label>Coordenadas</label>
                            <input type="input" class="form-control" id="coordenadas" name="coordenadas" />
                        </div>
                        <div class="form-group">
                            <label>Tipo de Encerramento</label>
                            <div class="radio">
                                <input type="radio" name="tipo_encerramento" id="temporario" value="temporario" checked />
                                <label class="form-check-label">
                                    Temporário (em determinadas horas do dia)
                                </label>
                            </div>
                            <div class="radio">
                                <input type="radio" name="tipo_encerramento" id="permanente" value="permanente" />
                                <label class="form-check-label">
                                    Permanente
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Data de Encerramento</label>
                            <input type="date" class="form-control" id="data_encerramento" name="data_encerramento" required />
                            <div class="invalid-feedback">Por favor insira a data de encerramento da via.</div>
                            <div class="alert alert-secondary" role="alert" id="data_encerramento">
                            </div>
                        </div>
                        <div class="form-group" id="div-hora-encerramento">
                            <label>Hora de Encerramento</label>
                            <input type="time" class="form-control" id="hora_encerramento" name="hora_encerramento" placeholder="Insira as horas de encerramento da via..." required />
                            <div class="invalid-feedback">Por favor insira as horas de encerramento da via.</div>
                        </div>
                        <div class="form-group">
                            <label>Data de Reabertura</label>
                            <input type="date" class="form-control" id="data_reabertura" name="data_reabertura" required />
                            <div class="invalid-feedback">Por favor insira a data de reabertura da via.</div>
                            <div class="alert alert-secondary" role="alert" id="data_reabertura">
                            </div>
                        </div>
                        <div class="form-group" id="div-hora-reabertura">
                            <label>Hora de Reabertura</label>
                            <input type="time" class="form-control" id="hora_reabertura" name="hora_reabertura" placeholder="Insira as horas de reabertura da via..." required />
                            <div class="invalid-feedback">Por favor insira as horas de reabertura da via.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary" name="Editar" id="Editar" value="Editar">Guardar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Registo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem a certeza de que quer eliminar este registo?
                </div>
                <form class="needs-validation was-validated" method="post">
                    <div class="modal-footer">
                        <div class="form-group" style="display:none;">
                            <label>ID</label>
                            <input type="input" class="form-control" id="id_delete" name="id_delete"/>
                        </div>
                        <button type="submit" class="btn btn-danger" name="Eliminar" id="Eliminar" value="Eliminar">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
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

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script src="js/functions.js"></script>

</body>

</html>