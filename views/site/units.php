<div class="display">
    <div class="display-buttons">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= \Src\Session::get('csrf_token') ?>">
            <div>
                <label>Вид:
                    <select name="type_id">
                        <option value="">Все</option>
                        <?php foreach ($unitTypes as $type): ?>
                            <option value="<?= $type->id ?>"
                                <?= ($_POST['type_id'] ?? '') == $type->id ? 'selected' : '' ?>>
                                <?= $type->title ?>
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
                        <option value="title" <?= ($_POST['sort_by'] ?? '') == 'title' ? 'selected' : '' ?>>Название</option>
                        <option value="type" <?= ($_POST['sort_by'] ?? '') == 'type' ? 'selected' : '' ?>>Вид</option>
                    </select>
                </label>
                <button type="submit" class="button">Применить</button>
            </div>
        </form>
        <div>
            <div>
                <a href="<?= app()->route->getUrl('/add-unit') ?>" class="button">Добавить</a>
            </div>
        </div>
    </div>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Вид</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($units as $unit): ?>
            <tr>
                <td><?= $unit->id ?></td>
                <td><?= $unit->title ?></td>
                <td><?= $unit->type_title ?? '---' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>