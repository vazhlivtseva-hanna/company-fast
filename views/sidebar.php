<?php $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>

<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link <?= $currentPath === '/dashboard' ? 'active' : '' ?>" href="/dashboard">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $currentPath === '/cow' ? 'active' : '' ?>" href="/cow">Page A</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $currentPath === '/download' ? 'active' : '' ?>" href="/download">Page B</a>
    </li>
    <?php if (isAdmin()): ?>
        <li class="nav-item"><a class="nav-link <?= $currentPath === '/statistics' ? 'active' : '' ?>" href="/statistics">Statistics</a></li>
        <li class="nav-item"><a class="nav-link <?= $currentPath === '/reports' ? 'active' : '' ?>" href="/reports">Reports</a></li>
    <?php endif; ?>
    <li class="nav-item mt-3">
        <a class="nav-link text-danger" href="/logout">Logout</a>
    </li>
</ul>
