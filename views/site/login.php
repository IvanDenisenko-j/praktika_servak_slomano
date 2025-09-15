<div class="add-edit">
    <h3>Вход в систему</h3>
    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <label>Email</label><input type="text" name="email">
        <label>Пароль</label><input type="password" name="password">
        <button class="button">Войти</button>
    </form>
    <h3><?= $message ?? ''; ?></h3>
</div>