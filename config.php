<?php
    $config = parse_ini_file("../config/config.ini");

    define('DB_SERVER', $config['db_server']);
    define('DB_USERNAME', $config['db_username']);
    define('DB_PASSWORD', $config['db_password']);
    define('DB_DATABASE_USERS', $config['db_database_users']);
    define('DB_DATABASE_CLOSED_ROADS', $config['db_database_closed_roads']);

    $mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE_USERS);

    if (mysqli_connect_errno()) {
        printf("Connection failed: %s\n", mysqli_connect_error());
        exit();
    }

    $mysqli_closed_roads = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE_CLOSED_ROADS);

    if (mysqli_connect_errno()) {
        printf("Connection failed: %s\n", mysqli_connect_error());
        exit();
    }

    function insertCivilProtectionTable($id, $name, $localizacao, $estado, $justificacao, $responsabilidade, $edital_documento, $coordenadas, $data_encerramento, $data_reabertura, $hora_encerramento, $hora_reabertura, $tipo_encerramento) {

        if (isset($id)) {
            if (isset($name) && empty($name)) {
                $name = "vazio";
            }

            if (isset($localizacao) && empty($localizacao)) {
                $localizacao = "vazio";
            }

            if (isset($estado) && empty($estado)) {
                $estado = "vazio";
            }

            if (isset($justificacao) && empty($justificacao)) {
                $justificacao = "vazio";
            }

            if (isset($responsabilidade) && empty($responsabilidade)) {
                $responsabilidade = "vazio";
            }

            if (isset($edital_documento) && empty($edital_documento)) {
                $edital_documento = "vazio";
            }

            if (isset($coordenadas) && empty($coordenadas)) {
                $coordenadas = "0,0";
            }

            if (isset($data_encerramento) && empty($data_encerramento)) {
                $data_encerramento = "0000-00-00";
            }

            if (isset($data_reabertura) && empty($data_reabertura)) {
                $data_reabertura = "0000-00-00";
            }

            if (isset($hora_encerramento) && empty($hora_encerramento)) {
                $hora_encerramento = "00:00";
            }

            if (isset($hora_reabertura) && empty($hora_reabertura)) {
                $hora_reabertura = "00:00";
            }

            if (isset($tipo_encerramento) && empty($tipo_encerramento)) {
                $tipo_encerramento = "permanente";
            }

            $sql = "INSERT INTO civil_protection (name, localizacao, estado, justificacao, responsabilidade, edital_documento, coordenadas, data_encerramento, data_reabertura, hora_encerramento, hora_reabertura, tipo_encerramento) VALUES ('".$name."','".$localizacao."','".$estado."','".$justificacao."','".$responsabilidade."','".$edital_documento."','".$coordenadas."','".$data_encerramento."','".$data_reabertura."','".$hora_encerramento."','".$hora_reabertura."','".$tipo_encerramento."')";

            global $mysqli_closed_roads;
            mysqli_set_charset($mysqli_closed_roads,"utf8");

            if (!mysqli_query($mysqli_closed_roads, $sql)) {
                printf("Error inserting record: " . mysqli_error($mysqli_closed_roads));
            } else {
                $last_id = mysqli_insert_id($mysqli_closed_roads);

                $sql = "SELECT * FROM civil_protection_geodata WHERE temp_civil_protection_id = '".$id."'";
                $result = mysqli_query($mysqli_closed_roads, $sql);

                if (mysqli_num_rows($result) === 1) {
                    $sql = "UPDATE civil_protection_geodata SET civil_protection_id = '" . $last_id . "' WHERE temp_civil_protection_id ='" . $id . "'";

                    if (!mysqli_query($mysqli_closed_roads, $sql)) {
                        printf("Error updating record: " . mysqli_error($mysqli_closed_roads));
                    }
                }
            }
            updateCivilProtectionTable($id);
        }
    }

    function updateCivilProtectionTable($id) {
        $sql = "UPDATE temp_civil_protection SET editado = true WHERE id = '".$id."'";

        global $mysqli_closed_roads;
        mysqli_set_charset($mysqli_closed_roads,"utf8");

        if (!mysqli_query($mysqli_closed_roads, $sql)) {
            printf("Error updating record: " . mysqli_error($mysqli_closed_roads));
        }
    }