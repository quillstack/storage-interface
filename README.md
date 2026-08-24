# Quillstack Storage Interface

[![Tests](https://github.com/quillstack/storage-interface/actions/workflows/tests.yml/badge.svg)](https://github.com/quillstack/storage-interface/actions/workflows/tests.yml)
[![Latest Version](https://img.shields.io/packagist/v/quillstack/storage-interface.svg)](https://packagist.org/packages/quillstack/storage-interface)
[![Downloads](https://img.shields.io/packagist/dt/quillstack/storage-interface.svg)](https://packagist.org/packages/quillstack/storage-interface)
[![PHP Version](https://img.shields.io/packagist/php-v/quillstack/storage-interface)](https://packagist.org/packages/quillstack/storage-interface)
[![StyleCI](https://github.styleci.io/repos/394759071/shield?branch=main)](https://github.styleci.io/repos/394759071?branch=main)
[![CodeFactor](https://www.codefactor.io/repository/github/quillstack/storage-interface/badge)](https://www.codefactor.io/repository/github/quillstack/storage-interface)
[![Quality Gate](https://sonarcloud.io/api/project_badges/measure?project=quillstack_storage-interface&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=quillstack_storage-interface)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=quillstack_storage-interface&metric=coverage)](https://sonarcloud.io/summary/new_code?id=quillstack_storage-interface)
[![Maintainability](https://sonarcloud.io/api/project_badges/measure?project=quillstack_storage-interface&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_storage-interface)
[![Reliability](https://sonarcloud.io/api/project_badges/measure?project=quillstack_storage-interface&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_storage-interface)
[![Security](https://sonarcloud.io/api/project_badges/measure?project=quillstack_storage-interface&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_storage-interface)
[![Maintainability](https://api.codeclimate.com/v1/badges/33a9f4af9af94a9e3e1e/maintainability)](https://codeclimate.com/github/quillstack/storage-interface/maintainability)
[![License](https://img.shields.io/packagist/l/quillstack/storage-interface)](https://github.com/quillstack/storage-interface/blob/main/LICENSE)

Common interface for Storage classes. Full documentation:
https://quillstack.org/storage-interface

Six methods, so that something writing files does not have to know which files. A package
depending on this one works the same against the disk, against a bucket, or against something
held in memory for a test.

## Why this exists

Three packages in this framework read and write files — the [cache](https://github.com/quillstack/cache),
the [logger](https://github.com/quillstack/logger) and [dotenv](https://github.com/quillstack/dotenv)
— and none of them should call `file_put_contents` itself, because then none of them can be
tested without a disk.

So they take this interface, and a test hands them something that keeps files in an array. It is
one interface with four methods, in its own package, so that depending on it does not mean
depending on an implementation.

## Requirements

- PHP 8.1 or newer

## Installation

```shell
composer require quillstack/storage-interface
```

## Usage

Ask for the interface, not for an implementation:

```php
use Quillstack\StorageInterface\StorageInterface;

final class Invoices
{
    public function __construct(private readonly StorageInterface $storage)
    {
    }

    public function keep(string $number, string $pdf): void
    {
        $this->storage->save("/invoices/{$number}.pdf", $pdf);
    }
}
```

Point it at whichever storage the application uses:

```php
$app = new App(__DIR__ . '/../.env', [
    StorageInterface::class => LocalStorage::class,
]);
```

## Technical documentation

| Method | Does |
| --- | --- |
| `get(string $path): mixed` | reads what is there |
| `exists(string $path): bool` | whether there is anything at that path |
| `missing(string $path): bool` | the other way round, because `!exists()` reads worse |
| `save(string $path, mixed $contents): bool` | writes, replacing whatever was there |
| `add(string $path, mixed $contents): bool` | writes on the end of what is there |
| `delete(string $path, string ...$more): bool` | removes one or several |

### What implements it

- [quillstack/local-storage](https://github.com/quillstack/local-storage) — files on disk

[quillstack/queue](https://github.com/quillstack/queue) writes messages through it, which is
why a queue can be pointed somewhere other than the local disk without knowing it has been.

There is nothing to run here: a package which only names things has no behaviour to test.

## Benchmark

**There is nothing here to measure.**

This package contains one interface and no code that runs. What it costs is an autoload of a few
hundred bytes; what it does is entirely done by whatever implements it — which for a local disk
is [quillstack/local-storage](https://github.com/quillstack/local-storage), and that one is
measured against `league/flysystem` in its own README.

A benchmark section that invented a number for an interface would be worse than one that says
this.

## Tests

```shell
composer test
composer stan
```

## The rest of Quillstack

This is one component of [Quillstack](https://github.com/quillstack), a PHP framework which is
as simple to use as it is strict about what it does.

- [quillstack/local-storage](https://github.com/quillstack/local-storage) — the implementation for a disk
- [quillstack/cache](https://github.com/quillstack/cache) — which writes entries through it
- [quillstack/logger](https://github.com/quillstack/logger) — which writes entries through it too

## License

MIT. See [LICENSE](LICENSE).
