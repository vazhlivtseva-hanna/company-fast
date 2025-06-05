<h2>User Activity Statistics</h2>

<form method="get" class="mb-3">
    <label>Date from: <input type="date" name="date_from" value="<?= $filters['date_from'] ?? '' ?>"></label>
    <label>Date to: <input type="date" name="date_to" value="<?= $filters['date_to'] ?? '' ?>"></label>
    <label>User (name/email):
        <input type="text" name="user_query" value="<?= htmlspecialchars($filters['user_query'] ?? '') ?>">
    </label>

    <label>Action type:
        <select name="action_type">
            <option value="">All</option>
            <option value="view_page" <?= $filters['action_type'] === 'view_page' ? 'selected' : '' ?>>view_page</option>
            <option value="button_click" <?= $filters['action_type'] === 'button_click' ? 'selected' : '' ?>>button_click</option>
        </select>
    </label>

    <label>Page name:
        <select name="page_name">
            <option value="">All</option>
            <option value="login" <?= $filters['page_name'] === 'login' ? 'selected' : '' ?>>login</option>
            <option value="logout" <?= $filters['page_name'] === 'logout' ? 'selected' : '' ?>>logout</option>
            <option value="registration" <?= $filters['page_name'] === 'registration' ? 'selected' : '' ?>>registration</option>
            <option value="pageA" <?= $filters['page_name'] === 'pageA' ? 'selected' : '' ?>>PageA</option>
            <option value="pageA" <?= $filters['page_name'] === 'pageB' ? 'selected' : '' ?>>PageB</option>
            <option value="statistics" <?= $filters['page_name'] === 'statistics' ? 'selected' : '' ?>>Statistics</option>
        </select>
    </label>

    <label>Button name:
        <select name="button_name">
            <option value="">All</option>
            <option value="buy" <?= $filters['button_name'] === 'buy' ? 'selected' : '' ?>>Buy</option>
            <option value="download" <?= $filters['button_name'] === 'download' ? 'selected' : '' ?>>Download</option>
        </select>
    </label>

    <button type="submit">Filter</button>
</form>

<table border="1" cellpadding="6" width="100%">
    <thead>
    <tr>
        <th>Date</th>
        <th>User</th>
        <th>Action</th>
        <th>Page</th>
        <th>Button</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($logs as $log): ?>
        <tr>
            <td><?= htmlspecialchars($log['created_at'] ?? '') ?></td>
            <td><?= htmlspecialchars($log['email'] ?? 'Guest') ?></td>
            <td><?= htmlspecialchars($log['action_type'] ?? '') ?></td>
            <td><?= htmlspecialchars($log['page_name'] ?? '') ?></td>
            <td><?= htmlspecialchars(is_string($log['button_name']) ? $log['button_name'] : '') ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
