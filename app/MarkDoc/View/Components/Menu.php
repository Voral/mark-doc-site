<?php

namespace App\MarkDoc\View\Components;

use App\MarkDoc\Entity\Dir;
use App\MarkDoc\Entity\Item;
use App\MarkDoc\Services\Tree;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private readonly Tree $tree, public ?Item $item = null, public string $path = '')
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $resolvedItem = $this->item ?? $this->tree->getRoot();
        if ($resolvedItem instanceof Dir) {
            return view('components.mark-doc-menu', ['items' => $resolvedItem->getChildren(), 'path' => $this->path]);
        }

        return '';
    }
}
