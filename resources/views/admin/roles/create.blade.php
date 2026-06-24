@extends('layouts.main')

@section('mainClass', 'pt-24 pb-section-gap max-w-container-max mx-auto px-gutter')
@section('bodyClass', 'font-body-md text-body-md selection:bg-primary-fixed selection:text-on-primary-fixed')

@section('content')

    <form action="{{ route('admin.roles.store') }}" method="POST" id="role-form">
        @csrf

        <div class="space-y-8">

            {{-- Breadcrumb + Header --}}
            <div>
                <nav class="flex items-center gap-2 font-metadata text-metadata text-secondary mb-4">
                    <a href="{{ route('admin.roles.index') }}" class="hover:text-primary transition-colors">Roles</a>
                    <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                    <span class="text-on-surface">New Role</span>
                </nav>
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-outline-variant">
                    <div>
                        <h1 class="font-headline-lg text-headline-lg text-on-surface">Create Role</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Set a name and choose which
                            abilities this role can perform.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.roles.index') }}"
                            class="px-4 py-2 border border-outline-variant text-secondary rounded-lg font-ui-label text-ui-label hover:border-primary hover:text-primary transition-all">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-primary text-on-primary px-5 py-2.5 rounded-lg font-ui-label text-ui-label hover:bg-primary-hover transition-all hover:shadow-md active:scale-95">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Save Role
                        </button>
                    </div>
                </div>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="flex gap-3 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <span class="material-symbols-outlined text-red-500 flex-shrink-0">error</span>
                    <div>
                        <p class="font-ui-label text-ui-label text-red-800 font-bold mb-1">Fix the following errors:</p>
                        <ul class="space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li class="font-body-sm text-body-sm text-red-700">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left: Basic Info --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white border border-outline-variant rounded-xl p-6 space-y-5">
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Basic Info</h2>

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block font-ui-label text-ui-label text-on-surface mb-1.5">
                                Role Name <span class="text-error">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="e.g. Editor, Moderator…"
                                class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('name') ? 'border-error bg-red-50 focus:ring-error/20' : 'border-outline-variant focus:border-primary focus:ring-primary/20' }} bg-white text-on-surface font-body-md text-body-md focus:outline-none focus:ring-2 transition-colors placeholder:text-surface-variant">
                            @error('name')
                                <p class="mt-1.5 font-metadata text-metadata text-error flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">warning</span>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description" class="block font-ui-label text-ui-label text-on-surface mb-1.5">
                                Description
                                <span class="font-metadata text-metadata text-secondary font-normal ml-1">(optional)</span>
                            </label>
                            <textarea id="description" name="description" rows="4" placeholder="What does this role do?"
                                class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('description') ? 'border-error bg-red-50 focus:ring-error/20' : 'border-outline-variant focus:border-primary focus:ring-primary/20' }} bg-white text-on-surface font-body-md text-body-md focus:outline-none focus:ring-2 transition-colors placeholder:text-surface-variant resize-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1.5 font-metadata text-metadata text-error flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">warning</span>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Selected Count Badge --}}
                    <div class="bg-white border border-outline-variant rounded-xl p-5 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-primary-container/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-[20px]">key</span>
                        </div>
                        <div>
                            <p class="font-headline-sm text-headline-sm text-on-surface" id="selected-count">0</p>
                            <p class="font-metadata text-metadata text-secondary">abilities selected</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Abilities --}}
                <div class="lg:col-span-2">
                    <div class="bg-white border border-outline-variant rounded-xl overflow-hidden">
                        <div class="px-6 py-5 border-b border-outline-variant flex items-center justify-between">
                            <div>
                                <h2 class="font-headline-sm text-headline-sm text-on-surface">Abilities</h2>
                                <p class="font-metadata text-metadata text-secondary mt-0.5">Choose what this role can
                                    access.</p>
                            </div>
                            <button type="button" id="toggle-all"
                                class="font-ui-label text-ui-label text-primary hover:underline text-sm">
                                Select all
                            </button>
                        </div>

                        @error('abilities')
                            <div class="px-6 py-3 bg-red-50 border-b border-red-100 flex items-center gap-2 text-red-700">
                                <span class="material-symbols-outlined text-[16px]">warning</span>
                                <span class="font-metadata text-metadata">{{ $message }}</span>
                            </div>
                        @enderror

                        @php
                            $allAbilities = config('abilities');
                            $grouped = [];
                            foreach ($allAbilities as $key => $label) {
                                $prefix = explode('.', $key)[0];
                                $grouped[$prefix][] = ['key' => $key, 'label' => $label];
                            }
                            $oldAbilities = old('abilities', []);
                        @endphp

                        <div class="divide-y divide-outline-variant">
                            @foreach ($grouped as $resource => $abilities)
                                <div class="px-6 py-5">
                                    {{-- Resource Header with Select-All toggle --}}
                                    <div class="flex items-center justify-between mb-3">
                                        <p class="font-ui-label text-ui-label font-bold text-on-surface capitalize">
                                            {{ $resource }}</p>
                                        <label class="flex items-center gap-1.5 cursor-pointer group">
                                            <input type="checkbox" class="group-toggle sr-only"
                                                data-group="{{ $resource }}"
                                                onchange="toggleGroup('{{ $resource }}', this.checked)">
                                            <span
                                                class="w-4 h-4 border-2 border-outline-variant rounded flex items-center justify-center group-hover:border-primary transition-colors group-toggle-indicator">
                                                <span
                                                    class="material-symbols-outlined text-primary text-[12px] hidden group-toggle-check">check</span>
                                            </span>
                                            <span
                                                class="font-metadata text-metadata text-secondary group-hover:text-primary transition-colors">All</span>
                                        </label>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach ($abilities as $ability)
                                            <label
                                                class="ability-label flex items-center gap-3 p-3 rounded-lg border border-outline-variant cursor-pointer hover:border-primary hover:bg-primary-container/5 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary-container/10"
                                                data-group="{{ $resource }}">
                                                <input type="checkbox" name="abilities[]" value="{{ $ability['key'] }}"
                                                    {{ in_array($ability['key'], $oldAbilities) ? 'checked' : '' }}
                                                    class="ability-checkbox w-4 h-4 rounded border-outline-variant text-primary accent-primary cursor-pointer"
                                                    onchange="updateCount()">
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-ui-label text-ui-label text-on-surface">
                                                        {{ $ability['label'] }}</p>
                                                    <p class="font-metadata text-metadata text-secondary font-mono">
                                                        {{ $ability['key'] }}</p>
                                                </div>
                                                <span
                                                    class="material-symbols-outlined text-[16px] text-primary opacity-0 ability-check transition-opacity">check_circle</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom Save Bar --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant">
                <a href="{{ route('admin.roles.index') }}"
                    class="px-4 py-2 border border-outline-variant text-secondary rounded-lg font-ui-label text-ui-label hover:border-primary hover:text-primary transition-all">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-primary text-on-primary px-6 py-2.5 rounded-lg font-ui-label text-ui-label hover:bg-primary-hover transition-all hover:shadow-md active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Save Role
                </button>
            </div>

        </div>
    </form>

@endsection

@push('style')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        body {
            background-color: #f9f9f9;
            color: #1a1c1c;
        }

        .ability-label:has(.ability-checkbox:checked) .ability-check {
            opacity: 1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function updateCount() {
            const checked = document.querySelectorAll('.ability-checkbox:checked').length;
            document.getElementById('selected-count').textContent = checked;

            // Sync group toggles
            document.querySelectorAll('.group-toggle').forEach(gt => {
                const group = gt.dataset.group;
                const total = document.querySelectorAll(`.ability-label[data-group="${group}"] .ability-checkbox`).length;
                const selected = document.querySelectorAll(`.ability-label[data-group="${group}"] .ability-checkbox:checked`).length;
                gt.checked = (total > 0 && total === selected);
            });
        }

        function toggleGroup(group, checked) {
            document.querySelectorAll(`.ability-label[data-group="${group}"] .ability-checkbox`).forEach(cb => {
                cb.checked = checked;
            });
            updateCount();
        }

        const toggleAllBtn = document.getElementById('toggle-all');

        function updateToggleAllState() {
            const total = document.querySelectorAll('.ability-checkbox').length;
            const checked = document.querySelectorAll('.ability-checkbox:checked').length;
            const allSelected = (total > 0 && total === checked);
            toggleAllBtn.textContent = allSelected ? 'Deselect all' : 'Select all';
            toggleAllBtn.dataset.all = allSelected;
        }

        toggleAllBtn.addEventListener('click', () => {
            const isAll = toggleAllBtn.dataset.all === 'true';
            const newState = !isAll;

            document.querySelectorAll('.ability-checkbox').forEach(cb => cb.checked = newState);
            document.querySelectorAll('.group-toggle').forEach(cb => cb.checked = newState);

            updateCount();
            updateToggleAllState();
        });

        // Init on load
        updateCount();
        updateToggleAllState();
    </script>
@endpush
