<?php

namespace Api\Shared\UserInterface\Utils;

use DateTime;

class Validator
{
    private array $errors = [];

    protected array $fields = [];

    protected array $data;

    private function __construct() {
    }

    public static function create(): self
    {
        return new self();
    }

    public function validate(): void
    {
        foreach ($this->fields as $field => $rules) {
            if (in_array('isNullable', $rules)) {
                unset($rules[array_search('isNullable', $rules)]); // elimino la regla de isNullable
                if (empty(trim($this->data[$field] ?? ''))) { // si el valor esta vacio, no aplico relgas
                    continue;
                }
            }
            foreach ($rules as $rule) {
                $this->{$rule}($field, $this->data[$field] ?? null);
            }
        }
    }

    // isNullable entonces, validar solo si hay informacion en el value, sino, no dar error

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function printErrors()
    {
        if (!empty($this->errors)) {
            header("HTTP/1.1 400 Bad Request");
            header('Content-Type: application/json');
            $json = json_encode([
                'status' => 'error',
                'message' => $this->errors
            ]);
            echo $json;
            exit();
        }
    }

    public function updateRule(string $field, array $rules): void
    {
        $this->fields[$field] = $rules;
    }

    private function isRequired(string $field, ?string $value = null): void
    {
        if (empty($value)) {
            $this->errors[] = "The field $field is required.";
        }
    }

    private function isEmail(string $field, ?string $value = null): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "The field $field must be email validate.";
        }
    }

    private function isInteger(string $field, ?string $value = null): void
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $this->errors[] = "The field $field must be integer.";
        }
    }

    private function isFloat(string $field, ?string $value = null): void
    {
        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $this->errors[] = "The field $field must be float number.";
        }
    }

    private function isDate(string $field, ?string $value = null): void
    {
        if (!DateTime::createFromFormat('Y-m-d', $value)) {
            $this->errors[] = "The field $field must be date valid in format Y-m-d.";
        }
    }
}
