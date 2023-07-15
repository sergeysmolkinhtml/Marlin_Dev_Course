<?php


class Validation
{
    private bool $passed = false;
    private array $errors = [];
    private ?Database $db = null;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function check($source, $items = []) : Static
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {

                $value = $source[$item]; // input

                if ($rule == 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } elseif (! empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("$item must be a maximum of {$rule_value} characters ");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}");
                            }
                            break;
                        case 'unique':
                            $check = $this->db->get($rule_value, [$item, '=', $value]);
                            if ($check->getCount()) {
                                $this->addError("{$item} already exists.");
                            }
                        break;
                    }
                }
            }
        }
        if (empty($this->errors)) {
            $this->passed = true;
        }
        return $this;
    }

    public function addError($error) : void
    {
        $this->errors[] = $error;
    }

    public function getErrors() : array
    {
        return $this->errors;
    }

    public function isPassed() : bool
    {
        return $this->passed;
    }
}