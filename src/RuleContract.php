<?php

namespace SSD\LaravelValidation;

use Illuminate\Contracts\Validation\Rule;

interface RuleContract extends Rule
{
    /**
     * Get the validation rule.
     */
    public function rule(): string;
}
