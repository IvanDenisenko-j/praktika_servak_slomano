<div class="display">
    <div class="display-buttons">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= \Src\Session::get('csrf_token') ?>">
            <div>
                <label>Роль:
                    <select name="role_id">
                        <option value="">Все</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role->id ?>"
                                <?= ($_POST['role_id'] ?? '') == $role->id ? 'selected' : '' ?>>
                                <?= $role->title ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <div>
                <label>Сортировка:
                    <select name="sort_by">
                        <option value="">По умолчанию</option>
                        <option value="id" <?= ($_POST['sort_by'] ?? '') == 'id' ? 'selected' : '' ?>>ID</option>
                        <option value="email" <?= ($_POST['sort_by'] ?? '') == 'email' ? 'selected' : '' ?>>Email</option>
                        <option value="role" <?= ($_POST['sort_by'] ?? '') == 'role' ? 'selected' : '' ?>>Роль</option>
                    </select>
                </label>
                <button type="submit" class="button">Применить</button>
            </div>
        </form>
        <div>
            <div>
                <a href="<?= app()->route->getUrl('/add-user') ?>" class="button">Добавить</a>
            </div>
        </div>
    </div>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Роль</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->name ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->role_title ?? '---' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>