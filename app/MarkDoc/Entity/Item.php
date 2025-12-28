<?php

namespace App\MarkDoc\Entity;

abstract class Item
{
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly string $path,
        public readonly bool $isDir,
    ) { }
}
