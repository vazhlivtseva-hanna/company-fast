<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 240px;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: white;
        }

        .main-content {
            flex-grow: 1;
            padding: 40px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
        <div class="wrapper">
         <?php if (isset($_SESSION['user'])): ?>
            <nav class="sidebar">
                <?php require_once __DIR__ . '/sidebar.php'; ?>
            </nav>
          <?php endif; ?>
        <main class="main-content"><?php require_once __DIR__ . '/../views/' . $viewPath . '.php'; ?>
        </main>
        </div>
</body>

</html>