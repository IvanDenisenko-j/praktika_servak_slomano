<div class="display">
    <div class="display-buttons">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= \Src\Session::get('csrf_token') ?>">
            <div>
                <label>Подразделение:
                    <select name="unit_id">
                        <option value="">Все</option>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?= $unit->id ?>" <?= ($_POST['unit_id'] ?? '') == $unit->id ? 'selected' : '' ?>>
                                <?= $unit->title ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Состав:
                    <select name="staff_id">
                        <option value="">Все</option>
                        <?php foreach ($staffs as $staff): ?>
                            <option value="<?= $staff->id ?>" <?= ($_POST['staff_id'] ?? '') == $staff->id ? 'selected' : '' ?>>
                                <?= $staff->title ?>
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
                        <option value="last_name" <?= ($_POST['sort_by'] ?? '') == 'last_name' ? 'selected' : '' ?>>Фамилия</option>
                        <option value="name" <?= ($_POST['sort_by'] ?? '') == 'name' ? 'selected' : '' ?>>Имя</option>
                        <option value="birth_date" <?= ($_POST['sort_by'] ?? '') == 'birth_date' ? 'selected' : '' ?>>Дата рождения</option>
                        <option value="unit_title" <?= ($_POST['sort_by'] ?? '') == 'unit_title' ? 'selected' : '' ?>>Подразделение</option>
                        <option value="staff_title" <?= ($_POST['sort_by'] ?? '') == 'staff_title' ? 'selected' : '' ?>>Состав</option>
                        <option value="position_title" <?= ($_POST['sort_by'] ?? '') == 'position_title' ? 'selected' : '' ?>>Должность</option>
                    </select>
                </label>
                <button type="submit" class="button">Применить</button>
            </div>
        </form>
        <div>
            <div>
                <a href="<?= app()->route->getUrl('/add-employee') ?>" class="button">Добавить</a>
            </div>
        </div>
    </div>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Пол</th>
            <th>Дата рождения</th>
            <th>Адрес прописки</th>
            <th>Должность</th>
            <th>Подразделение</th>
            <th>Состав</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($employees as $employee) {
            echo '<tr>'
                . '<td>' . $employee['id'] . '</td>'
                . '<td>' . ($employee['last_name'] ?? '---') . '</td>'
                . '<td>' . ($employee['name'] ?? '---') . '</td>'
                . '<td>' . ($employee['patronym'] ?? '---') . '</td>'
                . '<td>' . ($employee['gender_abbreviation'] ??'---') . '</td>'
                . '<td>' . ($employee['birth_date'] ?? '---') . '</td>'
                . '<td>' . ($employee['address'] ?? '---') . '</td>'
                . '<td>' . ($employee['position_title'] ?? '---') . '</td>'
                . '<td>' . ($employee['unit_title']  ?? '---') . '</td>'
                . '<td>' . ($employee['staff_title']  ?? '---') . '</td>'
                . '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>