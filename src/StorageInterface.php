<?php

declare(strict_types=1);

namespace Quillstack\StorageInterface;

interface StorageInterface
{
    /**
     * Retrieve the contents of a file.
     */
    public function get(string $path): mixed;

    /**
     * Checks if the file exists on the storage.
     */
    public function exists(string $path): bool;

    /**
     * Checks if the file is missing from the storage.
     */
    public function missing(string $path): bool;

    /**
     * Saves the contents to the file, the existing file is overwritten.
     */
    public function save(string $path, mixed $contents): bool;

    /**
     * Saves the contents at the end of the file.
     */
    public function add(string $path, mixed $contents): bool;

    /**
     * Deletes one or more files.
     */
    public function delete(string $path, string ...$more): bool;
}
