<h1>Sign up</h1>

<?php if (isset($errors)): ?>

<ul>
    <?php foreach ($errors as $field): ?>
        <?php foreach ($field as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    <?php endforeach; ?>
</ul>

<?php endif ?>

<form method="post" action="/signup">
    <label for="name">name</label>
    <input type="text" name="name" id="name"
        value="<?= htmlspecialchars($data['name']?? '') ?>">

    <label for="email">email</label>
    <input type="email" name="email" id="email"
           value="<?= htmlspecialchars($data['email']?? '') ?>">

    <label for="password">password</label>
    <input type="password" name="password" id="password">

    <label for="password_confirmation">repeat password</label>
    <input type="password" name="password_confirmation" id="password_confirmation">

    <button>sign up</button>
</form>