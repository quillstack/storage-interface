<?php

declare(strict_types=1);

namespace Quillstack\StorageInterface;

interface StorageInterface
{
    /**
     * Retrieve the contents of a file.
     *
     * @param string $path
     *
     * @return mixed
     */
    public function get(string $path): mixed;

    /**
     * Checks if the file exists on the storage.
     *
     * @param string $path
     *
     * @return bool
     */
    public function exists(string $path): bool;

    /**
     * Checks if the file is missing from the storage.
     *
     * @param string $path
     *
     * @return bool
     */
    public function missing(string $path): bool;

    /**
     * Saves the contents to the file.
     *
     * @param string $path
     * @param mixed $contents
     *
     * @return bool
     */
    public function save(string $path, mixed $contents): bool;

    /**
     * Deletes one or more files.
     *
     * @param string $path
     * @param string ...$more
     *
     * @return bool
     */
    public function delete(string $path, string ...$more): bool;
}
