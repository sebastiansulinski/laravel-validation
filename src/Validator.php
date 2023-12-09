<?php

namespace SSD\LaravelValidation;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator as ValidationValidator;

class Validator extends ValidationValidator
{
    /**
     * Validate an attribute using a custom rule object.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \SSD\LaravelValidation\RuleContract  $rule
     */
    protected function validateUsingCustomRule($attribute, $value, $rule): void
    {
        if (! request()->expectsJson()) {
            parent::validateUsingCustomRule($attribute, $value, $rule);

            return;
        }

        $attribute = $this->replacePlaceholderInString($attribute);

        $value = is_array($value) ? $this->replacePlaceholders($value) : $value;

        if ($rule instanceof ValidatorAwareRule) {
            $rule->setValidator($this);
        }

        if ($rule instanceof DataAwareRule) {
            $rule->setData($this->data);
        }

        if (! $rule->passes($attribute, $value)) {

            $this->failedRules[$attribute][$rule->rule()] = [];

            $this->messages->add($attribute, $rule->rule());
        }
    }

    /**
     * Add a failed rule and error message to the collection.
     *
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array  $parameters
     */
    public function addFailure($attribute, $rule, $parameters = []): void
    {
        if (! request()->expectsJson()) {
            parent::addFailure($attribute, $rule, $parameters);

            return;
        }

        if (! $this->messages) {
            $this->passes();
        }

        $this->messages->add($attribute, Str::snake($rule));

        $this->failedRules[$attribute][$rule] = $parameters;
    }
}
