# Isok

Isok is an IDE-friendly, dependency-free, flexible and fast PHP validation library.

- [Installation](#installation)
- [Usage](#usage)
- [Inbuilt Rules](#inbuilt-rules)
- [Custom Rules](#custom-rules)

## Installation

```bash
$ composer require ntzm/isok
```

## Usage

The `Ntzm\Isok\Validator` class takes a list of [rules](#rules), and has a single method: `validate`.

```php
$validator = new Validator(
    new IsArray,
    (new HasKey('email'))->that(new IsEmailAddress),
    (new HasKey('username'))->that(new IsString, new HasLengthBetween(3, 20))
);

$validation = $validator->validate([
    'email' => 'bob@example.com',
    'username' => 'bobby',
]);

$validation->passes(); // true
$validation->fails();  // false
```

## Inbuilt Rules

### `Is`

Determines if the value is exactly equal.

```php
$v = new Validator(new Is('1'));

$v->validate('1')->passes(); // true
$v->validate(1)->passes(); // false
```

### `When`

If all conditions are met, apply a set of rules.

This rule allows you to build complex logic, such as requiring a `password_confirmation` key if a `password` key is
passed.

```php
$v = new Validator((new When(new IsString))->then(new Is('a')));

$v->validate('a')->passes(); // true
$v->validate(1)->passes(); // true
$v->validate('b')->passes(); // false
```

### `Arr`

#### `HasKey`

Determines if the value has a specific key.

```php
$v = new Validator(new HasKey('foo'));

$v->validate(['foo' => 'bar'])->passes(); // true
$v->validate([])->passes(); // false
```

You can also add rules for the value of that key, if it exists, using the `that` method:

```php
$v = new Validator((new HasKey('foo'))->that(new IsString, new EndsWith('ar')));

$v->validate(['foo' => 'bar'])->passes(); // true
$v->validate(['foo' => 'baz'])->passes(); // true
$v->validate(['foo' => 5])->passes(); // false
$v->validate([])->passes(); // false
```

#### `IsArray`

Determines if the value is an array.

```php
$v = new Validator(new IsArray);

$v->validate([])->passes(); // true
$v->validate(5)->passes(); // false
```

#### `IsSubsetOf`

Determines if the value is a subset of an array.

```php
$v = new Validator(new IsSubsetOf('red', 'green', 'blue'));

$v->validate(['red', 'green'])->passes(); // true
$v->validate([])->passes(); // true
$v->validate(['red', 'green', 'purple'])->passes(); // false
```

### `Bool`

#### `IsBool`

Determines if the value is a boolean.

```php
$v = new Validator(new IsBool);

$v->validate(true)->passes(); // true
$v->validate(false)->passes(); // true
$v->validate(5)->passes(); // false
```

#### `IsFalse`

Determines if the value is `false`.

```php
$v = new Validator(new IsBool);

$v->validate(false)->passes(); // true
$v->validate(true)->passes(); // false
$v->validate(0)->passes(); // false
```

#### `IsTrue`

Determines if the value is `true`.

```php
$v = new Validator(new IsBool);

$v->validate(true)->passes(); // true
$v->validate(false)->passes(); // false
$v->validate(1)->passes(); // false
```

### `Net`

#### `IsEmailAddress`

Determines if the value is an email address.

**Note: This uses PHP's `FILTER_VALIDATE_EMAIL`, which may not cover all your needs. If it does not, you are free to
create your own [custom rule](#custom-rules) to match your needs.**

```php
$v = new Validator(new IsEmailAddress);

$v->validate('bob@example.com')->passes(); // true
$v->validate('bob')->passes(); // false
$v->validate(5)->passes(); // false
```

#### `IsIPAddress`

Determines if the value is an IP address.

```php
$v = new Validator(new IsIpAddress);

$v->validate('127.0.0.1')->passes(); // true
$v->validate('::1')->passes(); // true
$v->validate('')->passes(); // false
```

#### `IsIPv4Address`

Determines if the value is an IPv4 address.

```php
$v = new Validator(new IsIpAddress);

$v->validate('127.0.0.1')->passes(); // true
$v->validate('::1')->passes(); // false
$v->validate('')->passes(); // false
```

#### `IsIPv6Address`

Determines if the value is an IPv6 address.

```php
$v = new Validator(new IsIpAddress);

$v->validate('::1')->passes(); // true
$v->validate('127.0.0.1')->passes(); // false
$v->validate('')->passes(); // false
```

### `Number`

#### `IsFloat`

Determines if the value is a float.

```php
$v = new Validator(new IsFloat);

$v->validate(1.0)->passes(); // true
$v->validate(1)->passes(); // false
```

#### `IsInt`

```php
$v = new Validator(new IsInt);

$v->validate(1)->passes(); // true
$v->validate(1.0)->passes(); // false
```

### `Object`

#### `IsInstanceOf`

### `String`

#### `EndsWith`

#### `IsString`

#### `MatchesRegex`

#### `StartsWith`

### `UUID`

#### `IsUUID`

#### `IsUUIDv1`

#### `IsUUIDv2`

#### `IsUUIDv3`

#### `IsUUIDv4`

#### `IsUUIDv5`

## Custom Rules

To create your own custom rule, create a class that implements the `Rule` interface.

A rule only needs one method defined, `violationsFor`, which takes a value and a path, and returns `Violations`.

`$value` is the value passed into the `Validator::validate` method.

`$path` is an instance of `Path`, which is used for getting the route taken in arrays.

You can indicate that the value has no violations by returning `Violations::none()`.

```php
final class IsOverEighteen implements Rule
{
    public function violationsFor($value, Path $path) : Violations
    {
        if ($value > 18) {
            return Violations::none();
        }

        return new Violations(new Violation('is not over 18', $this, $path));
    }
}
```

For more in depth examples, check out the source code of the inbuilt rules.
