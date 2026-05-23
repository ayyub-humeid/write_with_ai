<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class DeniedWordsRule implements ValidationRule
{
    private array $deniedWords;

    /**
     * Create a new rule instance.
     *
     * @param array $deniedWords
     */
    public function __construct(array $deniedWords = ['badword1', 'badword2', 'spam', 'offensive'])
    {
        $this->deniedWords = $deniedWords;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->deniedWords as $word) {
            if (stripos($value, $word) !== false) {
                $fail("The " . str_replace('_', ' ', $attribute) . " contains a forbidden word: '{$word}'.");
            }
        }
    }
}
