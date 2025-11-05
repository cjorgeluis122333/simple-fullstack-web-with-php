<?php
require_once "src/php/service.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Manejar preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        echo json_encode(obtenerUsuarios());
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['nombre'], $data['correo'], $data['rol'])) {
            insertarUsuario($data['nombre'], $data['correo'], $data['rol']);
            echo json_encode(["status" => "ok"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Datos incompletos"]);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            parse_str(file_get_contents("php://input"), $data);
            $id = $data['id'] ?? null;
        }

        if ($id) {
            eliminarUsuario((int)$id);
            echo json_encode(["status" => "ok"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "ID faltante"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
}
