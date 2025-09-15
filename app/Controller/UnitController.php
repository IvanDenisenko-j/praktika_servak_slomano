<?php

namespace Controller;

use Src\Request;
use Src\Validator\Validator;
use Src\View;
use Model\Unit;
use Model\UnitType;

class UnitController
{
    public function units(): string
    {
        $query = Unit::query()
            ->select(['units.*', 'unit_types.title as type_title'])
            ->leftJoin('unit_types', 'units.type_id', '=', 'unit_types.id');

        // Фильтрация по виду
        if (!empty($_POST['type_id'])) {
            $query->where('type_id', $_POST['type_id']);
        }

        // Сортировка
        $sortColumns = [
            'id' => 'units.id',
            'title' => 'units.title',
            'type' => 'unit_types.title'
        ];

        if (!empty($_POST['sort_by']) && isset($sortColumns[$_POST['sort_by']])) {
            $query->orderBy($sortColumns[$_POST['sort_by']]);
        }

        $units = $query->get();

        return new View('site.units', [
            'units' => $units,
            'unitTypes' => UnitType::all()
        ]);
    }

    public function addUnitForm(): string
    {
        return new View('site.add_unit', [
            'unitTypes' => UnitType::all()
        ]);
    }

    public function addUnit(Request $request): string
    {
        // Валидация обязательных полей
        $validator = new Validator($request->all(), [
            'title' => ['required'],
            'type_id' => ['required'],
        ], [
            'required' => 'Поле :field пусто'
        ]);

        if($validator->fails()){
            return new View('site.add_unit',
                ['unitTypes' => UnitType::all(),
                 'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
        }

        Unit::create([
            'title' => $_POST['title'],
            'type_id' => $_POST['type_id']
        ]);

        return $this->units();
    }
}