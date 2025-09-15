<div class="add-edit">
    <h3>Добавить сотрудника</h3>
    <form method="POST" name="csrf_token" action="<?= app()->route->getUrl('/add-employee') ?>">
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
        <label>Фамилия</label>
        <input type="text" name="last_name" required>

        <label>Имя</label>
        <input type="text" name="name" required>

        <label>Отчество</label>
        <input type="text" name="patronym">

        <label>Пол</label>
        <select name="gender_id" required>
            <?php foreach ($genders as $gender): ?>
                <option value="<?= $gender->id ?>"><?= $gender->abbreviation ?></option>
            <?php endforeach; ?>
        </select>

        <label>Дата рождения</label>
        <input type="date" name="birth_date" required>

        <label>Адрес прописки</label>
        <input type="text" name="address" required>

        <label>Должность</label>
        <select name="position_id" required>
            <?php foreach ($positions as $position): ?>
                <option value="<?= $position->id ?>"><?= $position->title ?></option>
            <?php endforeach; ?>
        </select>

        <label>Подразделение</label>
        <select name="unit_id" required>
            <?php foreach ($units as $unit): ?>
                <option value="<?= $unit->id ?>"><?= $unit->title ?></option>
            <?php endforeach; ?>
        </select>

        <label>Состав</label>
        <select name="staff_id" required>
            <?php foreach ($staffs as $staff): ?>
                <option value="<?= $staff->id ?>"><?= $staff->title ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="button">Добавить</button>
    </form>
</div>