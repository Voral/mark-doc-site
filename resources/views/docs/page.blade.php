@extends('layouts.app')

@section('menu')
    <x-mark-doc-menu :path="$path"/>
@endsection

@section('content')
    @section('title', $title)
    {!! $content !!}

    @isset($children)
        <x-mark-doc-menu/>
        <ul>
            @foreach($children as $child)
                <li><a href="{{ route('mark-doc.show',['path' => $child->slug],false) }}">
                        {{$child->title }}
                    </a></li>
            @endforeach
        </ul>
    @endisset
@endsection
