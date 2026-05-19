@extends('layouts.main')

@section('title', 'Create Category')

@section('content')
    <div class="max-w-container-max mx-auto px-gutter py-12">
        <header class="mb-8">
            <a href="{{ route('dashboard.categories.index') }}" class="text-primary hover:underline font-ui-label text-ui-label flex items-center gap-1 mb-2">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back to categories
            </a>
            <h1 class="font-display-lg text-display-lg text-on-surface">New Category</h1>
            <p class="font-body-md text-on-surface-variant">Register a new taxonomy class to classify and group editorial assets.</p>
        </header>

        @include('dashboard.categories._form', [
            'action' => route('dashboard.categories.store'),
            'method' => 'POST'
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
