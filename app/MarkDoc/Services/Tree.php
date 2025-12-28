<?php

namespace App\MarkDoc\Services;

use App\MarkDoc\Entity\Dir;
use App\MarkDoc\Entity\File;
use App\MarkDoc\Entity\Item;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class Tree
{
    private readonly string $markdownPath;
    private array $index = [];
    private ?Dir $root = null;

    public function __construct(
        string $markdownPath,
        private readonly TreeSorter $sorter
    ) {
        $this->markdownPath = $this->getDocsPath($markdownPath);
    }

    public function initTree(): void
    {
        $finder = new Finder();
        $finder
            ->files()
            ->name('*.md')
            ->in($this->markdownPath)
            ->sortByName();

        $this->root = new Dir('', '', $this->markdownPath);

        foreach ($finder as $file) {
            /** @var SplFileInfo $file */
            $relativePath = $file->getRelativePathname();
            $this->buildTree($this->root, $relativePath, $file->getBasename('.md'));
        }

        $this->root->sort($this->sorter);
    }

    private function buildTree(Dir &$tree, string $path, string $title): void
    {
        $parts = explode(DIRECTORY_SEPARATOR, $path);
        $fileName = array_pop($parts);
        $current = &$tree;
        $fullPath = [];
        foreach ($parts as $part) {
            $fullPath[] = $part;
            $directory = $this->buildDir($fullPath, $part);
            $current->addChild($directory);
            $current = &$this->index[$directory->slug];
        }
        $current->addChild($this->buildFile($fullPath, $title, $fileName));
    }

    private function buildDir(array $fullPath, string $title): Dir
    {
        $path = implode(DIRECTORY_SEPARATOR, $fullPath);
        $directorySlug = strtolower($path);
        if (!isset($this->index[$directorySlug])) {
            $this->index[$directorySlug] = new Dir(
                $title,
                $directorySlug,
                $this->markdownPath . DIRECTORY_SEPARATOR . $path
            );
        }
        return $this->index[$directorySlug];
    }

    private function buildFile(array $fullPath, string $title, string $fileName): File
    {
        $path = implode(DIRECTORY_SEPARATOR, $fullPath);
        $slug = strtolower($path . DIRECTORY_SEPARATOR . $title);
        $path = $this->markdownPath . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $fileName;

        $content = file_get_contents($path);
        $matches = [];
        preg_match('/^#\s+(.+)$/m', $content, $matches);
        if (isset($matches[1])) {
            $title = str_replace('\#', '#', trim($matches[1]));
        }
        $this->index[$slug] = new File($title, $slug, $path);
        return $this->index[$slug];
    }


    private function sortTree(array $tree): array
    {
        uasort($tree, function ($a, $b) {
            return ($a['is_file'] ?? false) <=> ($b['is_file'] ?? false) ?: // файлы в конец
                ($a['__title'] ?? $a['title'] ?? '') <=> ($b['__title'] ?? $b['title'] ?? '');
        });

        foreach ($tree as &$item) {
            if (isset($item['__children'])) {
                $item['__children'] = $this->sortTree($item['__children']);
            }
        }

        return $tree;
    }

    private function getDocsPath(string $markdownPath): string
    {
        $resolvedPath = str_starts_with($markdownPath, '/')
            ? $markdownPath
            : base_path($markdownPath);

        $realPath = realpath($resolvedPath);

        if ($realPath === false) {
            throw new \RuntimeException("Markdown docs directory not found: {$markdownPath}");
        }

        return $realPath;
    }

    public function resolve(string $path): false|Item
    {
        if ($this->root === null) {
            $this->initTree();
        }
        return $this->index[$path] ?? false;
    }

    public function getRoot(): Dir
    {
        if ($this->root === null) {
            $this->initTree();
        }
        return $this->root;
    }
}
