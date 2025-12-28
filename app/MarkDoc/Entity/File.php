<?php

namespace App\MarkDoc\Entity;

class File extends Item
{
    public function __construct(string $title, string $slug, string $path)
    {
        parent::__construct($title, $slug, $path, false);
    }
}
