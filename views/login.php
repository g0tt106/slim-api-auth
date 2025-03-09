<h1>Log in</h1>

<?php if (isset($errors)): ?>

<p><?= $errors ?></p>

<?php endif; ?>

<form method="post" action="/login">

    <label for="email">email</label>
    <input type="email" name="email" id="email"
           value="<?= htmlspecialchars($data['email']?? '') ?>">

    <label for="password">password</label>
    <input type="password" name="password" id="password">

    <button>log in</button>
</form>