<h2>Page B: Download</h2>

<form action="/download" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token) ?>">
    <button type="submit" class="btn btn-success">Download</button>
</form>

