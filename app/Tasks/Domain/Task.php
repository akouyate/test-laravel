<?php

declare(strict_types=1);

namespace App\Tasks\Domain;

enum TaskType: string
{
    case CallReason = 'call_reason';
    case CallActions = 'call_actions';
    case Satisfaction = 'satisfaction';
    case CallSegments = 'call_segments';
    case Summary = 'summary';
}

class Task
{
    private string $text;
    private array $types;

    public function __construct(string $text, array $types)
    {
        $this->text = $text;
        $this->types = $types;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public static function createFromArray(array $data): self
    {
        return new self($data['text'], $data['types']);
    }

    /**
     * @param string $task
     * @return bool
     */
    public static function isValidTask(string $task): bool
    {
        foreach (TaskType::cases() as $case) {
            if ($case->value === $task) {
                return true;
            }
        }

        return false;
    }

    public function __toString()
    {
        return json_encode([
            'text' => $this->text,
            'types' => $this->types,
        ]);
    }
}
