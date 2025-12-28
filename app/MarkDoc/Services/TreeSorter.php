<?php

namespace App\MarkDoc\Services;

use App\MarkDoc\Entity\File;
use App\MarkDoc\Entity\Item;

class TreeSorter
{
    public function sort(array &$children): void
    {
        uasort($children, function (Item $a, Item $b) {
            return ($a instanceof File) <=> ($b instanceof File) ?: $a->title <=> $b->title;
        });
    }
}
