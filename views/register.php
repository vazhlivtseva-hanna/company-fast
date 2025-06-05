<h2>Register</h2>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>
<form class="needs-validation" method="POST">
    <input class="form-control mb-1" name="first_name" placeholder="First Name" required aria-describedby="firstNameHelp">
    <small id="firstNameHelp" class="form-text text-muted mb-2">Enter your first name (e.g., Anna)</small>

    <input class="form-control mb-1" name="last_name" placeholder="Last Name" required aria-describedby="lastNameHelp">
    <small id="lastNameHelp" class="form-text text-muted mb-2">Enter your last name</small>

    <input class="form-control mb-1" type="email" name="email" placeholder="Email" required aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted mb-2">Use a valid email address (e.g., example@domain.com)</small>

    <input class="form-control mb-1" type="password" name="password" placeholder="Password" required aria-describedby="passwordHelp">
    <small id="passwordHelp" class="form-text text-muted mb-3">
        Password must be 6–16 characters and include at least one lowercase letter, one uppercase letter, one number, and one special character.
    </small>
    <div>
        <button class="btn btn-primary">Register</button>
        <a class="btn btn-secondary" href="/login">Login</a>
    </div>
</form>