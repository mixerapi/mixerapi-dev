<?php
declare(strict_types=1);

return [
    [
        'table' => 'actors',
        'columns' => [
            'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'autoIncrement' => true],
            'first_name' => ['type' => 'string', 'length' => 45,],
            'last_name' => ['type' => 'string', 'length' => 45,],
            'modified' => ['type' => 'datetime', 'length' => null,],
            'write' => ['type' => 'string', 'length' => 8, 'null' => true,],
            'read' => ['type' => 'string', 'length' => 8, 'null' => true,],
            'hide' => ['type' => 'string', 'length' => 8, 'null' => true,],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ],
    [
        'table' => 'addresses',
        'columns' => [
            'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'autoIncrement' => true],
            'address' => ['type' => 'string', 'length' => 50, 'null' => false, 'precision' => null],
            'address2' => ['type' => 'string', 'length' => 50, 'null' => true, 'precision' => null],
            'district' => ['type' => 'string', 'length' => 20, 'null' => false, 'precision' => null],
            'city_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'autoIncrement' => null],
            'postal_code' => ['type' => 'string', 'length' => 10, 'null' => true, 'precision' => null],
            'phone' => ['type' => 'string', 'length' => 20, 'null' => false, 'precision' => null],
            'location' => ['type' => 'string', 'length' => 255, 'precision' => null],
            'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ]
    ],
    [
        'table' => 'film_actors',
        'columns' => [
            'uuid' => ['type' => 'uuid', 'length' => null,],
            'actor_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true,],
            'film_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true,],
            'modified' => ['type' => 'datetime', 'length' => null,],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['uuid'], 'length' => []],
        ],
    ],
    [
        'table' => 'films',
        'columns' => [
            'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'autoIncrement' => true],
            'title' => ['type' => 'string', 'length' => 255,],
            'description' => ['type' => 'text', 'length' => null, 'null' => true,],
            'release_year' => ['type' => 'string', 'length' => 255, 'null' => true,],
            'language_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true,],
            'rental_duration' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'default' => '3',],
            'length' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true,],
            'rating' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'G',],
            'special_features' => ['type' => 'string', 'length' => 255, 'null' => true,],
            'modified' => ['type' => 'datetime', 'length' => null, 'null' => true,],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ],
    [
        'table' => 'department_employees',
        'columns' => [
            'employee_id' => ['type' => 'integer', 'length' => 11,],
            'department_id' => ['type' => 'smallinteger', 'length' => 6,],
            'from_date' => ['type' => 'date', 'length' => null,],
            'to_date' => ['type' => 'date', 'length' => null,],
            'id' => ['type' => 'integer', 'length' => 11, 'autoIncrement' => true,],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ],
    [
        'table' => 'departments',
        'columns' => [
            'id' => ['type' => 'smallinteger', 'length' => 6,],
            'name' => ['type' => 'string', 'length' => 64, ],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'dept_name' => ['type' => 'unique', 'columns' => ['name'], 'length' => []],
        ],
    ],
    [
        'table' => 'employee_salaries',
        'columns' => [
            'employee_id' => ['type' => 'integer', 'length' => 11,],
            'salary' => ['type' => 'integer', 'length' => 11,],
            'from_date' => ['type' => 'date', 'length' => null,],
            'to_date' => ['type' => 'date', 'length' => null,],
            'id' => ['type' => 'integer', 'length' => 11, 'autoIncrement' => true,],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ],
    [
        'table' => 'employees',
        'columns' => [
            'id' => ['type' => 'integer', 'length' => 11,],
            'first_name' => ['type' => 'string', 'length' => 14, ],
            'last_name' => ['type' => 'string', 'length' => 16, ],
            'gender' => ['type' => 'string', 'length' => null, ],
            'hire_date' => ['type' => 'date', 'length' => null,],
            'birth_date' => ['type' => 'date', 'length' => null,],
            'write' => ['type' => 'string', 'length' => null, ],
            'read' => ['type' => 'string', 'length' => null, ],
            'hide' => ['type' => 'string', 'length' => null, ],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ],
    [
        'table' => 'employee_titles',
        'columns' => [
            'employee_id' => ['type' => 'integer', 'length' => 11,],
            'title' => ['type' => 'string', 'length' => 50, ],
            'from_date' => ['type' => 'date', 'length' => null,],
            'to_date' => ['type' => 'date', 'length' => null, 'null' => true,],
            'id' => ['type' => 'integer', 'length' => 11, 'autoIncrement' => true,],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ],
    [
        'table' => 'users',
        'columns' => [
            'id' => ['type' => 'string', 'length' => null, 'unsigned' => false, 'null' => false, 'autoIncrement' => false],
            'email' => ['type' => 'string', 'length' => 128, 'null' => false, 'default' => null],
            'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null],
            'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false],
            'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ]
    ]
];
