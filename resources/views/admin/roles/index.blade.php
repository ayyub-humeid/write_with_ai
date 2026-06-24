
@extends('layouts.main')

@section('mainClass', 'pt-24 pb-section-gap max-w-container-max mx-auto px-gutter')
@section('bodyClass', 'font-body-md text-body-md selection:bg-primary-fixed selection:text-on-primary-fixed')

@section('content')
<div class="space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 pb-6 border-b border-outline-variant">
        <div>
            <p class="font-metadata text-metadata text-secondary uppercase tracking-widest mb-1">Administration</p>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Roles</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                Define what each role can do across the platform.
            </p>
        </div>
        <a href="{{ route('admin.roles.create') }}"
            class="inline-flex items-center gap-2 bg-primary text-on-primary px-5 py-2.5 rounded-lg font-ui-label text-ui-label hover:bg-primary-hover transition-all hover:shadow-md active:scale-95 self-start sm:self-auto">
            <span class="material-symbols-outlined text-[18px]">add</span>
            New Role
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            <span class="font-ui-label text-ui-label">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
            <span class="material-symbols-outlined text-red-600">error</span>
            <span class="font-ui-label text-ui-label">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Stats Strip --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @php
            $statCards = [
                ['label' => 'Total Roles', 'value' => $roles->total(), 'icon' => 'shield'],
                ['label' => 'Total Abilities', 'value' => count(config('abilities')), 'icon' => 'key'],
                ['label' => 'This Page', 'value' => $roles->count(), 'icon' => 'layers'],
                ['label' => 'Pages', 'value' => $roles->lastPage(), 'icon' => 'menu_book'],
            ];
        @endphp
        @foreach($statCards as $card)
            <div class="bg-white border border-outline-variant rounded-xl p-4 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-primary-container/20 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary text-[18px]">{{ $card['icon'] }}</span>
                </div>
                <div>
                    <p class="font-headline-sm text-headline-sm text-on-surface leading-none">{{ $card['value'] }}</p>
                    <p class="font-metadata text-metadata text-secondary mt-0.5">{{ $card['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Roles Table --}}
    <div class="bg-white border border-outline-variant rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-outline-variant bg-surface-container/30">
                        <th class="text-left px-6 py-4 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Role</th>
                        <th class="text-left px-6 py-4 font-ui-label text-ui-label text-secondary uppercase tracking-wider hidden md:table-cell">Description</th>
                        <th class="text-left px-6 py-4 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Abilities</th>
                        <th class="text-left px-6 py-4 font-ui-label text-ui-label text-secondary uppercase tracking-wider hidden sm:table-cell">Created</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($roles as $role)
                        <tr class="group hover:bg-surface-container/20 transition-colors">
                            {{-- Role Name --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-primary-container/15 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-primary text-[18px]">shield_person</span>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.roles.show', $role) }}"
                                            class="font-ui-label text-ui-label font-bold text-on-surface hover:text-primary transition-colors">
                                            {{ $role->name }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            {{-- Description --}}
                            <td class="px-6 py-4 hidden md:table-cell">
                                <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-1 max-w-xs">
                                    {{ $role->description ?? '—' }}
                                </p>
                            </td>
                            {{-- Abilities Count --}}
                            <td class="px-6 py-4">
                                @php $count = is_array($role->abilities) ? count($role->abilities) : 0; @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $count === 0 ? 'bg-surface-container text-secondary' : 'bg-primary-container/20 text-primary' }}">
                                    <span class="material-symbols-outlined text-[12px]">key</span>
                                    {{ $count }} {{ Str::plural('ability', $count) }}
                                </span>
                            </td>
                            {{-- Created At --}}
                            <td class="px-6 py-4 hidden sm:table-cell">
                                <span class="font-metadata text-metadata text-secondary">
                                    {{ $role->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1 justify-end opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.roles.show', $role) }}"
                                        title="View"
                                        class="p-2 rounded-lg text-secondary hover:text-primary hover:bg-primary-container/10 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </a>
                                    <a href="{{ route('admin.roles.edit', $role) }}"
                                        title="Edit"
                                        class="p-2 rounded-lg text-secondary hover:text-primary hover:bg-primary-container/10 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                        onsubmit="return confirm('Delete \'{{ addslashes($role->name) }}\' permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete"
                                            class="p-2 rounded-lg text-secondary hover:text-error hover:bg-red-50 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-3 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[48px] text-outline">shield</span>
                                    <p class="font-ui-label text-ui-label">No roles yet</p>
                                    <p class="font-body-sm text-body-sm">Create your first role to control access across the platform.</p>
                                    <a href="{{ route('admin.roles.create') }}"
                                        class="mt-2 inline-flex items-center gap-1.5 text-primary font-ui-label text-ui-label hover:underline">
                                        <span class="material-symbols-outlined text-[16px]">add</span>
                                        Create a role
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($roles->hasPages())
            <div class="px-6 py-4 border-t border-outline-variant flex items-center justify-between">
                <p class="font-metadata text-metadata text-secondary">
                    Showing {{ $roles->firstItem() }}–{{ $roles->lastItem() }} of {{ $roles->total() }} roles
                </p>
                <div class="flex items-center gap-1">
                    {{-- Previous --}}
                    @if($roles->onFirstPage())
                        <span class="p-2 rounded-lg text-outline cursor-not-allowed">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </span>
                    @else
                        <a href="{{ $roles->previousPageUrl() }}"
                            class="p-2 rounded-lg text-secondary hover:text-primary hover:bg-primary-container/10 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </a>
                    @endif

                    @foreach($roles->getUrlRange(1, $roles->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="w-8 h-8 flex items-center justify-center rounded-lg font-ui-label text-ui-label transition-colors
                                {{ $page == $roles->currentPage() ? 'bg-primary text-on-primary' : 'text-secondary hover:bg-primary-container/10 hover:text-primary' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    {{-- Next --}}
                    @if($roles->hasMorePages())
                        <a href="{{ $roles->nextPageUrl() }}"
                            class="p-2 rounded-lg text-secondary hover:text-primary hover:bg-primary-container/10 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </a>
                    @else
                        <span class="p-2 rounded-lg text-outline cursor-not-allowed">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>
@endsection

@push('style')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }
    body { background-color: #f9f9f9; color: #1a1c1c; }
</style>
@endpush