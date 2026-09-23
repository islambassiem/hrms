<?php

declare(strict_types=1);

namespace Tests\Support;

use InvalidArgumentException;

final class InvalidDataset
{
    private array $datasets = [];

    public function __construct(
        private readonly ?string $field = null,
    ) {}

    public function build(): array
    {
        return $this->datasets;
    }

    public function notString(): self
    {
        $this->addRule(
            $this->field.' is not a string',
            [$this->field => ['not', 'a', 'string']],
            $this->field(),
        );

        return $this;
    }

    public function notInteger(): self
    {
        $this->addRule(
            $this->field.' is not an integer',
            [$this->field => 'not-an-integer'],
            $this->field(),
        );

        return $this;
    }

    public function aboveMax(int $max): self
    {
        $this->addRule(
            $this->field.' exceeds maximum value',
            [$this->field => $max + 1],
            $this->field(),
        );

        return $this;
    }

    public function belowMin(int $min): self
    {
        $this->addRule(
            $this->field.' is below minimum value',
            [$this->field => $min - 1],
            $this->field(),
        );

        return $this;
    }

    public function tooShort(int $min = 5): self
    {
        throw_if($min < 1, InvalidArgumentException::class, 'Minimum length must be greater than zero.');

        $this->addRule(
            $this->field.' is too short',
            [$this->field => str_repeat('a', $min - 1)],
            $this->field(),
        );

        return $this;
    }

    public function tooLong(int $max = 255): self
    {
        throw_if($max < 0, InvalidArgumentException::class, 'Maximum length cannot be negative.');

        $this->addRule(
            $this->field.' is too long',
            [$this->field => str_repeat('a', $max + 1)],
            $this->field(),
        );

        return $this;
    }

    public function required(): self
    {
        $this->addRule(
            $this->field.' is null',
            [$this->field => null],
            $this->field(),
        );

        return $this;
    }

    public function future(): self
    {
        $field = $this->field();

        $this->addRule(
            "$field is in the future",
            [$field => now()->copy()->addDay()],
            $field,
        );

        return $this;
    }

    public function past(): self
    {
        $field = $this->field();

        $this->addRule(
            "$field is in the past",
            [$field => now()->copy()->subDay()],
            $field,
        );

        return $this;
    }

    public function invalidDateOrder(
        string $startField,
        string $endField,
    ): self {
        $this->addRule(
            "$endField is before $startField",
            [
                $startField => now(),
                $endField => now()->subDay(),
            ],
            $endField,
        );

        return $this;
    }

    public function invalidName(
        string $field = 'name',
        int $min = 2,
        int $max = 30,
    ): self {
        throw_if($min < 1, InvalidArgumentException::class, 'Minimum name length must be greater than zero.');

        throw_if($max < $min, InvalidArgumentException::class, 'Maximum name length must be greater than or equal to minimum length.');

        $this->addRule(
            $field.'.ar is null',
            [
                $field => [
                    'ar' => null,
                    'en' => 'name in english',
                ],
            ],
            $field.'.ar',
        );

        $this->addRule(
            $field.'.ar is too short',
            [
                $field => [
                    'ar' => str_repeat('a', $min - 1),
                    'en' => 'name in english',
                ],
            ],
            $field.'.ar',
        );

        $this->addRule(
            $field.'.ar is too long',
            [
                $field => [
                    'ar' => str_repeat('a', $max + 1),
                    'en' => 'name in english',
                ],
            ],
            $field.'.ar',
        );

        $this->addRule(
            $field.'.en is null',
            [
                $field => [
                    'en' => null,
                    'ar' => 'name in arabic',
                ],
            ],
            $field.'.en',
        );

        $this->addRule(
            $field.'.en is too short',
            [
                $field => [
                    'en' => str_repeat('a', $min - 1),
                    'ar' => 'name in arabic',
                ],
            ],
            $field.'.en',
        );

        $this->addRule(
            $field.'.en is too long',
            [
                $field => [
                    'en' => str_repeat('a', $max + 1),
                    'ar' => 'name in arabic',
                ],
            ],
            $field.'.en',
        );

        return $this;
    }

    public function invalidFormat(
        string $invalidValue = 'invalid-format',
    ): self {
        $this->addRule(
            $this->field.' has invalid format',
            [$this->field => $invalidValue],
            $this->field(),
        );

        return $this;
    }

    public function digits(int $length): self
    {
        throw_if($length < 1, InvalidArgumentException::class, 'Digit length must be greater than zero.');

        $field = $this->field();

        $this->addRule(
            "$field has too many digits",
            [$field => str_repeat('1', $length + 1)],
            $field,
        );

        if ($length > 1) {
            $this->addRule(
                "$field has too few digits",
                [$field => str_repeat('1', $length - 1)],
                $field,
            );
        }

        $this->addRule(
            "$field contains non-digits",
            [$field => str_repeat('a', $length)],
            $field,
        );

        return $this;
    }

    public function notBoolean(): self
    {
        $field = $this->field();

        $this->addRule(
            "$field is a string",
            [$field => 'true'],
            $field,
        );

        $this->addRule(
            "$field is an array",
            [$field => []],
            $field,
        );

        return $this;
    }

    public function invalidRegex(
        string $pattern,
        string $value,
        ?string $label = null,
    ): self {
        $result = preg_match($pattern, $value);

        if ($result === false) {
            throw new InvalidArgumentException(
                sprintf('Invalid regex pattern: "%s".', $pattern)
            );
        }

        if ($result === 1) {
            throw new InvalidArgumentException(
                \sprintf(
                    'The value "%s" matches the pattern "%s".',
                    $value,
                    $pattern,
                )
            );
        }

        $this->addRule(
            $label ?? $this->field.' has an invalid format',
            [$this->field => $value],
            $this->field(),
        );

        return $this;
    }

    private function addRule(
        string $label,
        array $payload,
        string $invalidField,
    ): void {
        $this->datasets[$label] = [
            $payload,
            [$invalidField],
        ];
    }

    private function field(): string
    {
        throw_if(
            $this->field === null,
            InvalidArgumentException::class,
            'A field is required for this invalid dataset.'
        );

        return $this->field;
    }
}
