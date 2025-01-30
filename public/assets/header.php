<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacation Portal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">Vacation Portal</a>
        <div class="collapse navbar-collapse">
                <?php if (isset($_SESSION['username'])): ?>
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php 
                        echo ($_SESSION['role'] === 'manager') 
                        ? 'getAllUsers' 
                        :  'requests/' . $_SESSION['id'];
                    ?>">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>

                <?php if ($_SESSION['role'] === 'manager'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>ManagerController/getAllRequests">
                        <i class="bi bi-clipboard"></i> Requests
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
        </div>
        <div class="d-flex align-items-center">
            <?php if (isset($_SESSION['username'])): ?>
                <span class="text-white me-3">Hello, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="<?= BASE_URL ?>AuthController/logout" class="btn btn-light btn-sm">Sign Out</a>
            <?php endif; ?>
        </div>
    </div>
</nav>