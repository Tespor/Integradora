<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['nombre']) && isset($_SESSION['rol'])) {
    echo json_encode([
        'status' => 1,
        'rol' => $_SESSION['rol']
    ]);
} else {
    echo json_encode([
        'status' => 0
    ]);
}
exit();
?>