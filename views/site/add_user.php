<div class="add-edit">
    <h3>Добавить пользователя</h3>
    <form method="POST" action="<?= app()->route->getUrl('/add-user') ?>">
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Пароль</label>
        <input type="password" name="password" required>

        <label>Имя</label>
        <input type="text" name="name" required>

        <label>Роль</label>
        <select name="role_id" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role->id ?>"><?= $role->title ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="button">Добавить</button>
    </form>
</div>
