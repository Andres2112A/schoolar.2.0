<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit();
}

include('../../config/database.php');

// Si se solicita listar usuarios
$show_users = isset($_GET['list_users']);
$users = [];

if ($show_users) {
    $sql = "SELECT id, firstName, lastName, email FROM users ORDER BY id";
    $res = pg_query($conn, $sql);
    while ($row = pg_fetch_assoc($res)) {
        $users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Schoolar2</title>
    <link rel="stylesheet" href="../css/sb-admin-2.min.css">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body class="bg-gradient-primary">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <h2 class="mb-4 text-primary">
                            <i class="fas fa-user-circle"></i>
                            Bienvenido <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <nav class="mb-4 text-center">
            <a href="home.php" class="btn btn-primary mx-1">Dashboard</a>
            <a href="home.php?list_users=1" class="btn btn-info mx-1">List user</a>
            <a href="logout.php" class="btn btn-danger mx-1">Cerrar sesión</a>
        </nav>

        <?php if ($show_users): ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary">Usuarios registrados</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['firstname'] ?? $user['firstName']); ?></td>
                                    <td><?php echo htmlspecialchars($user['lastname'] ?? $user['lastName']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if (empty($users)): ?>
                            <div class="alert alert-info text-center">No hay usuarios registrados.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>