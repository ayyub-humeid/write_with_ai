@extends('layouts.main')

@section('title', 'Edit Category - ' . $category->name)

@section('content')
    <div class="max-w-container-max mx-auto px-gutter py-12">
        <header class="mb-8">
            <a href="{{ route('dashboard.categories.index') }}" class="text-primary hover:underline font-ui-label text-ui-label flex items-center gap-1 mb-2">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back to categories
            </a>
            <h1 class="font-display-lg text-display-lg text-on-surface">Edit Category</h1>
            <p class="font-body-md text-on-surface-variant">Update the classification rules, slug pathways, or metadata for this category.</p>
        </header>

        @include('dashboard.categories._form', [
            'action' => route('dashboard.categories.update', $category->id),
            'method' => 'PUT'
        ])
    </div>
@endsection

@section('bodyClass', 'bg-surface text-on-surface font-body-md')

@push('style')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
@endpush
