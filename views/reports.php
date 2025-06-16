<h2>Reports</h2>

<canvas id="reportChart" width="600" height="300"></canvas>

<table border="1" cellpadding="6" style="margin-top: 20px;">
    <thead>
    <tr>
        <th>Date</th>
        <th>View A</th>
        <th>View B</th>
        <th>Buy a cow</th>
        <th>Download</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($reportData as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['date']) ?></td>
            <td><?= (int) $row['pageA_views'] ?></td>
            <td><?= (int) $row['pageB_views'] ?></td>
            <td><?= (int) $row['buy_clicks'] ?></td>
            <td><?= (int) $row['download_clicks'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Подключение Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('reportChart').getContext('2d');
    const data = {
        labels: <?= json_encode($chartData['dates']) ?>,
        datasets: [
            {
                label: 'Page View A',
                data: <?= json_encode($chartData['pageA_views']) ?>,
                borderColor: 'blue',
                fill: false
            },
            {
                label: 'Page View B',
                data: <?= json_encode($chartData['pageB_views']) ?>,
                borderColor: 'green',
                fill: false
            },
            {
                label: 'Buy a Cow',
                data: <?= json_encode($chartData['buy_clicks']) ?>,
                borderColor: 'orange',
                fill: false
            },
            {
                label: 'Download',
                data: <?= json_encode($chartData['download_clicks']) ?>,
                borderColor: 'red',
                fill: false
            },
        ]
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'User Activity Report' }
            }
        }
    });
</script>
