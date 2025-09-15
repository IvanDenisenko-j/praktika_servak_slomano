<?php

namespace Src\Validator;

abstract class AbstractValidator
{
    //Наименование валидируемого поля
    protected string $field = '';
    //Значение валидируемого поля
    protected $value;
    //Дополнительные аргументы
    protected array $args = [];
    //Массив ключей для замены в строке с ошибкой
    protected array $messageKeys = [];
    //Базовое сообщение об ошибке
    protected string $message = '';

    public function __construct(string $fieldName, $value, $args = [], string $message = null)
    {
        $this->field = $fieldName;
        $this->value = $value;
        $this->args = $args;
        $this->message = $message ?? $this->message;

        $this->messageKeys = [
            ":value" => $this->value,
            ":field" => $this->field
        ];
    }

    //Если правило валидации не прошло, то возвращаем сообщение об ошибке
    public function validate()
    {
        if (!$this->rule())
            return $this->messageError();
        return true;
    }

    //Замена ключей на конкретные значения в сообщении об ошибке
    private function messageError(): string
    {
        foreach ($this->messageKeys as $key => $value) {
            $message = str_replace($key, (string)$value, $this->message);
        }
        return $message;
    }

    //Основное правило валидации. Его должны переопределить классы-потомки
    abstract public function rule(): bool;
}