<?php

namespace Controller;

use Model\Gender;
use Model\Position;
use Src\Request;
use Src\Validator\Validator;
use Src\View;
use Model\Employee;
use Model\Unit;
use Model\Staff;
use Src\Auth\Auth;
use Carbon\Carbon;

class EmployeeController
{
    public function employees(): string
    {
        $query = Employee::query()
            ->select([
                'employees.*',
                'genders.abbreviation as gender_abbreviation',
                'units.title as unit_title',
                'staff.title as staff_title',
                'positions.title as position_title',
            ])
            ->leftJoin('genders', 'employees.gender_id', '=', 'genders.id')
            ->leftJoin('units', 'employees.unit_id', '=', 'units.id')
            ->leftJoin('staff', 'employees.staff_id', '=', 'staff.id')
            ->leftJoin('positions', 'employees.position_id', '=', 'positions.id');

        // Фильтрация
        if (!empty($_POST['unit_id'])) {
            $query->where('unit_id', $_POST['unit_id']);
        }

        if (!empty($_POST['staff_id'])) {
            $query->where('staff_id', $_POST['staff_id']);
        }

        // Сортировка
        $sortMapping = [
            'id' => 'employees.id',
            'last_name' => 'last_name',
            'name' => 'name',
            'gender' => 'gender.abbreviation',
            'birth_date' => 'birth_date',
            'unit_title' => 'units.title',
            'staff_title' => 'staff.title',
            'position_title' => 'positions.title'
        ];

        if (!empty($_POST['sort_by']) && isset($sortMapping[$_POST['sort_by']])) {
            $query->orderBy($sortMapping[$_POST['sort_by']]);
        }

        $employees = $query->get();

        foreach($employees as $employee) {
            $employee['birth_date'] = Carbon::parse($employee['birth_date'])->format('d.m.Y');
        }

        return new View('site.employees', [
            'employees' => $employees,
            'units' => Unit::all(),
            'staffs' => Staff::all(),
        ]);
    }

    public function addEmployeeForm(): string
    {
        return new View('site.add_employee', [
            'genders' => Gender::all(),
            'positions' => Position::all(),
            'units' => Unit::all(),
            'staffs' => Staff::all(),
        ]);
    }

    public function addEmployee(Request $request): string
    {
        $validator = new Validator($request->all(), [
            'last_name' => ['required'],
            'name' => ['required'],
            'gender_id' => ['required'],
            'birth_date' => ['required'],
            'address' => ['required'],
            'position_id' => ['required'],
            'unit_id' => ['required'],
            'staff_id' => ['required'],
        ],
            [
                'required' => 'Поле :field пусто',
            ]
        );

        if($validator->fails()){
            return new View('site.add_employee', [
                'genders' => Gender::all(),
                'positions' => Position::all(),
                'units' => Unit::all(),
                'staffs' => Staff::all(),
                'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
            ]);
        }

        // Создание сотрудника
        Employee::create([
            'last_name' => $_POST['last_name'],
            'name' => $_POST['name'],
            'patronym' => $_POST['patronym'] ?? null,
            'gender_id' => $_POST['gender_id'],
            'birth_date' => $_POST['birth_date'],
            'address' => $_POST['address'],
            'position_id' => $_POST['position_id'],
            'unit_id' => $_POST['unit_id'],
            'staff_id' => $_POST['staff_id'],
            'creator_id' => Auth::user()->id,
        ]);

        return $this->employees();
    }
}