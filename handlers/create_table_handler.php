<?php
require_once '../controllers/UserController.php';
require_once '../handlers/Session.php';

Session::start();

header('Content-Type: application/json');

$table = $_POST['table'] ?? [];
$table_name = $table['name'] ?? '';
$columns = $table['columns'] ?? [];

if (empty($table_name) || empty($columns)) {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid input. Please provide a table name and columns.'
    ]);
    exit;
}

$formattedColumns = [];
foreach ($columns as $column) {
    $name = $column['name'] ?? '';
    $type = $column['type'] ?? '';
    if (!empty($name) && !empty($type)) {
        $formattedColumns[] = [
            'name' => $name,
            'type' => $type
        ];
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Invalid column format. Each column must have a name and type.',
            'column' => $column
        ]);
        exit;
    }
}

$userController = new UserController();

try {
    $userController->createTable($table_name, $formattedColumns);
    echo json_encode([
        'success' => true,
        'message' => 'Table created successfully!'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

exit;
?>
