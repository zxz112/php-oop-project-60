### Hexlet tests and linter status:
[![Actions Status](https://github.com/zxz112/php-oop-project-60/workflows/hexlet-check/badge.svg)](https://github.com/zxz112/php-oop-project-60/actions)

### Hexlet tests and linter status:
[![Actions Status](https://github.com/zxz112/php-oop-project-60/workflows/hexlet-check/badge.svg)](https://github.com/zxz112/php-oop-project-60/actions)

### Валидация строк
```php
<?php

$v = new \Hexlet\Validator\Validator();

$schema = $v->string();
// Каждый вызов возвращает новую схему,
// так как у нас может быть любое количество независимых проверок
$schema2 = $v->string(); // $schema != $schema2

$schema->isValid(''); // true

// Null валидное значение для всех валидаторов
// если не задан required
$schema->isValid(null); // true

$schema->isValid('what does the fox say'); // true

$schema->required();

$schema2->isValid(''); // По прежнему валидно, это другая схема
$schema->isValid(null); // А тут не валидно
$schema->isValid(''); // И тут тоже

$schema->isValid('hexlet'); // true

$schema->contains('what')->isValid('what does the fox say'); // true
$schema->contains('whatthe')->isValid('what does the fox say'); // false

// Если один валидатор вызывался несколько раз
// то последний имеет приоритет (перетирает предыдущий)
$v->string()->minLength(10)->minLength(5)->isValid('Hexlet'); // true
```

### Валидация чисел
```php
<?php

$v = new \Hexlet\Validator\Validator();

$schema = $v->number();

$schema->isValid(null); // true

$schema->required();

$schema->isValid(null); // false

// Достаточно работать с типом Integer
$schema->isValid(7); // true

$schema->positive()->isValid(10); // true

$schema->range(-5, 5);

$schema->isValid(-3); // false
$schema->isValid(5); // true
```

### Валидация массивов
```php
<?php

$v = new \Hexlet\Validator\Validator();

$schema = $v->array();

$schema->isValid(null); // true

$schema = $schema->required();

$schema->isValid([]); // true
$schema->isValid(['hexlet']); // true

$schema->sizeof(2); // true

$schema->isValid(['hexlet']); // false
$schema->isValid(['hexlet', 'code-basics']); // true
```

### Валидация массивов
```php
<?php

$v = new \Hexlet\Validator\Validator();

$schema = $v->array();

$schema->isValid(null); // true

$schema = $schema->required();

$schema->isValid([]); // true
$schema->isValid(['hexlet']); // true

$schema->sizeof(2); // true

$schema->isValid(['hexlet']); // false
$schema->isValid(['hexlet', 'code-basics']); // true

// Позволяет описывать валидацию для ключей массива
$schema->shape([
    'name' => $v->string()->required(),
    'age' => $v->number()->positive(),
]);

$schema->isValid(['name' => 'kolya', 'age' => 100]); // true
$schema->isValid(['name' => 'maya', 'age' => null]); // true
$schema->isValid(['name' => '', 'age' => null]); // false
$schema->isValid(['name' => 'ada', 'age' => -5]); // false
```

### Добавление собственных валидаторов
```php
<?php

$v = new \Hexlet\Validator\Validator();

$fn = fn($value, $start) => str_starts_with($value, $start);
// Метод добавления новых валидаторов
// addValidator($type, $name, $fn)
$v->addValidator('string', 'startWith', $fn);

// Новые валидаторы вызываются через метод test
$schema = $v->string()->test('startWith', 'H');
$schema->isValid('exlet'); // false
$schema->isValid('Hexlet'); // true

$fn = fn($value, $min) => $value >= $min;
$v->addValidator('number', 'min', $fn);

$schema = $v->number()->test('min', 5);
$schema->isValid(4); // false
$schema->isValid(6); // true

// Если валидатора нет, то бросаем исключение
$v->addValidator('wrong-name', 'startWith', $fn); // boom!
```