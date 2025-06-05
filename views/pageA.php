<h2>Page A: Buy a cow</h2>

<div id="buy-section">
    <button id="buy-cow-btn" class="btn btn-primary">Buy a cow</button>
    <p id="thank-you-msg" style="display: none; color: green;">Thank you for your purchase!</p>
    <p id="error-msg" style="display: none; color: red;"></p>
</div>
<script>
    document.getElementById('buy-cow-btn').addEventListener('click', function () {
        fetch('/cow/buy', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('error-msg').textContent = data.message || 'Error occurred';
                    document.getElementById('error-msg').style.display = 'block';
                } else {
                    document.getElementById('buy-cow-btn').style.display = 'none';
                    document.getElementById('thank-you-msg').style.display = 'block';
                }
            })
            .catch(err => {
                document.getElementById('error-msg').textContent = 'Something went wrong';
                document.getElementById('error-msg').style.display = 'block';
            });
    });
</script>
