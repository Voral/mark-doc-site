<?php

namespace App\MarkDoc\Entity;

use App\MarkDoc\Services\TreeSorter;

class Dir extends Item
{
    public array $children = [];
    public function __construct(string $title, string $slug, string $path)
    {
        parent::__construct($title, $slug, $path, true);
    }

    public function addChild(Item $child): void
    {
        $this->children[$child->slug] = $child;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function sort(TreeSorter $sorter):void
    {
        $sorter->sort($this->children);
        foreach ($this->children as $child) {
            if ($child instanceof Dir) {
                $child->sort($sorter);
            }
        }
    }
}
