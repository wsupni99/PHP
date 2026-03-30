<?php

class ArrayWrapper {
    private array $data = [];

    public function __construct(array $data = []) {
        $this->data = $data;
    }

    public function __get(string $key): mixed {
        return $this->data[$key] ?? null;
    }

    public function __set(string $key, mixed $value): void {
        $this->data[$key] = $value;
    }

    public function __isset(string $key): bool {
        return isset($this->data[$key]);
    }

    public function __unset(string $key): void {
        unset($this->data[$key]);
    }

    public function __toString(): string {
        return json_encode($this->data);
    }

    public function __invoke(mixed $key = null): mixed {
        if ($key === null) {
            return $this->data;
        }
        return $this->data[$key] ?? null;
    }

    public function __clone(): void {
        foreach ($this->data as $k => $v) {
            if (is_object($v)) {
                $this->data[$k] = clone $v;
            }
        }
    }
}

// Тесты
$wrapper = new ArrayWrapper(['name' => 'PHP', 'count' => 42, 'obj' => new stdClass()]);

echo $wrapper->name;
echo "\n";
$wrapper->new = 'value';
var_dump(isset($wrapper->new));
unset($wrapper->new);
var_dump(isset($wrapper->new));

echo $wrapper . "\n";

echo $wrapper('name') . "\n";
var_dump($wrapper());

$obj1 = $wrapper->obj;
$obj1->test = 'original';

$wrapper2 = clone $wrapper;
var_dump($wrapper->obj);
var_dump($wrapper2->obj);