<?php

namespace App\Http\Controllers;

use App\MarkDoc\Entity\Dir;
use App\MarkDoc\Entity\File;
use App\MarkDoc\Services\Tree;
use Illuminate\View\View;
use Parsedown;

class DocsController extends Controller
{
    public function __construct(
        private readonly Tree $filesystem,
    )
    {
    }

    public function show($path = ''): View
    {
        if ($path === '') {
            $item = $this->filesystem->getRoot();
        } else {
            $item = $this->filesystem->resolve($path);
        }
        if ($item instanceof File) {
            $parser = new Parsedown();
            $html = $parser->text(file_get_contents($item->path));
            preg_match('#<h1>(.*)</h1>#', $html, $matches);
            $data = [
                'content' => $html,
                'title' => $matches[1] ?? ''
            ];
        } elseif ($item instanceof Dir) {
            $data = [
                'content' => '',
                'title' => '',
                'children' => $item->getChildren(),
                'item' => $item
            ];
        } else {
            abort(404);
        }
        $data['path'] = $path;

        return view('docs.page', $data);
    }
}
