<?php

declare(strict_types=1);

use Ntzm\Isok\Formatter\FlatArrayFormatter;
use Ntzm\Isok\Rule\Arr\HasKey;
use Ntzm\Isok\Rule\Arr\IsArray;
use Ntzm\Isok\Rule\Is;
use Ntzm\Isok\Rule\Net\IsEmailAddress;
use Ntzm\Isok\Rule\Arr\IsSubsetOf;
use Ntzm\Isok\Rule\When;
use Ntzm\Isok\Validator;

require_once __DIR__ . '/vendor/autoload.php';

$data = [
    'email' => 'admin@foo.com',
    'roles' => [
        'Admin',
        'Authon',
    ],
    'foo' => '',
];

$validator = new Validator(
    new IsArray(),
    (new HasKey('email'))->that(new IsEmailAddress()),
    (new HasKey('roles'))->that(
        new IsArray(),
        new IsSubsetOf(
            'Admin',
            'Author',
            'Mage',
        ),
    ),
    (new When(new HasKey('foo')))->then((new HasKey('email'))->that(new Is('admin@foo.com'))),
);

$result = $validator->validate($data);

var_dump((new FlatArrayFormatter())->format($result->violations()));
