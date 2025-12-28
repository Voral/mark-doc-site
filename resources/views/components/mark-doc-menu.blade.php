@isset($items)
    <ul class="m-doc-menu">
        @foreach($items as $child)
            <li class="m-doc-menu__item">
                <a
                    href="{{ route('mark-doc.show',['path' => $child->slug],false) }}"
                @class([
                    'm-doc-menu__link',
                    'm-doc-menu_active' => $path === $child->slug
                ])>
                    {{$child->title }}
                </a>
                <x-mark-doc-menu :item="$child" :path="$path"/>
            </li>
        @endforeach
    </ul>
@endisset
