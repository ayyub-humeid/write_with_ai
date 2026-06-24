@extends('layouts.main')

@section('mainClass', 'pt-24 pb-section-gap max-w-container-max mx-auto px-gutter')
@section('bodyClass', 'font-body-md text-body-md selection:bg-primary-fixed selection:text-on-primary-fixed')

@section('content')
    <div class="space-y-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 font-metadata text-metadata text-secondary">
            <a href="{{ route('admin.roles.index') }}" class="hover:text-primary transition-colors">Roles</a>
            <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
            <span class="text-on-surface">{{ $role->name }}</span>
        </nav>

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start gap-4 pb-6 border-b border-outline-variant">
            <div class="w-14 h-14 rounded-xl bg-primary-container/20 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-primary text-[28px]">shield_person</span>
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="font-headline-lg text-headline-lg text-on-surface">{{ $role->name }}</h1>
                @if ($role->description)
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">{{ $role->description }}</p>
                @endif
                <div class="flex flex-wrap items-center gap-3 mt-3">
                    <span class="inline-flex items-center gap-1.5 font-metadata text-metadata text-secondary">
                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                        Created {{ $role->created_at->format('M d, Y') }}
                    </span>
                    <span class="text-outline">•</span>
                    <span class="inline-flex items-center gap-1.5 font-metadata text-metadata text-secondary">
                        <span class="material-symbols-outlined text-[14px]">update</span>
                        Updated {{ $role->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('admin.roles.edit', $role) }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 border border-primary text-primary rounded-lg font-ui-label text-ui-label hover:bg-primary-container/10 transition-all">
                    <span class="material-symbols-outlined text-[16px]">edit</span>
                    Edit
                </a>
                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                    onsubmit="return confirm('Delete \'{{ addslashes($role->name) }}\' permanently?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 border border-outline-variant text-secondary rounded-lg font-ui-label text-ui-label hover:border-error hover:text-error hover:bg-red-50 transition-all">
                        <span class="material-symbols-outlined text-[16px]">delete</span>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <span class="font-ui-label text-ui-label">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Abilities --}}
        <div class="bg-white border border-outline-variant rounded-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-outline-variant flex items-center justify-between">
                <div>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Abilities</h2>
                    <p class="font-metadata text-metadata text-secondary mt-0.5">
                        {{ is_array($role->abilities) ? count($role->abilities) : 0 }} of {{ count(config('abilities')) }}
                        abilities granted
                    </p>
                </div>
                {{-- Progress Bar --}}
                @php
                    $total = count(config('abilities'));
                    $granted = is_array($role->abilities) ? count($role->abilities) : 0;
                    $pct = $total > 0 ? round(($granted / $total) * 100) : 0;
                @endphp
                <div class="flex items-center gap-3">
                    <div class="w-32 h-2 bg-surface-container rounded-full overflow-hidden hidden sm:block">
                        <div class="h-full bg-primary rounded-full transition-all" style="width: {{ $pct }}%">
                        </div>
                    </div>
                    <span class="font-ui-label text-ui-label text-primary font-bold">{{ $pct }}%</span>
                </div>
            </div>

            @php
                $allAbilities = config('abilities');
                $roleAbilities = is_array($role->abilities) ? $role->abilities : [];
                // Group by resource prefix
                $grouped = [];
                foreach ($allAbilities as $key => $label) {
                    $prefix = explode('.', $key)[0];
                    $grouped[$prefix][] = ['key' => $key, 'label' => $label];
                }
            @endphp

            <div class="divide-y divide-outline-variant">
                @foreach ($grouped as $resource => $abilities)
                    @php
                        $grantedInGroup = collect($abilities)
                            ->filter(fn($a) => in_array($a['key'], $roleAbilities))
                            ->count();
                    @endphp
                    <div class="px-6 py-5">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <span
                                    class="font-ui-label text-ui-label font-bold text-on-surface capitalize">{{ $resource }}</span>
                                <span
                                    class="font-metadata text-metadata text-secondary">({{ $grantedInGroup }}/{{ count($abilities) }})</span>
                            </div>
                            @if ($grantedInGroup === count($abilities))
                                <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full">Full
                                    Access</span>
                            @elseif($grantedInGroup === 0)
                                <span
                                    class="text-xs font-bold text-secondary bg-surface-container px-2 py-0.5 rounded-full">No
                                    Access</span>
                            @else
                                <span
                                    class="text-xs font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">Partial</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($abilities as $ability)
                                @php $granted = in_array($ability['key'], $roleAbilities); @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium border
                                {{ $granted
                                    ? 'bg-primary-container/15 border-primary/20 text-primary'
                                    : 'bg-surface-container border-outline-variant text-secondary line-through opacity-50' }}">
                                    <span class="material-symbols-outlined text-[14px]">
                                        {{ $granted ? 'check_circle' : 'cancel' }}
                                    </span>
                                    {{ $ability['label'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Meta Card --}}
        <div class="bg-white border border-outline-variant rounded-xl p-6">
            <h2 class="font-headline-sm text-headline-sm text-on-surface mb-4">Details</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <dt class="font-metadata text-metadata text-secondary uppercase tracking-wider mb-1">ID</dt>
                    <dd class="font-ui-label text-ui-label text-on-surface font-mono">#{{ $role->id }}</dd>
                </div>
                <div>
                    <dt class="font-metadata text-metadata text-secondary uppercase tracking-wider mb-1">Created</dt>
                    <dd class="font-ui-label text-ui-label text-on-surface">{{ $role->created_at->format('M d, Y · H:i') }}
                    </dd>
                </div>
                <div>
                    <dt class="font-metadata text-metadata text-secondary uppercase tracking-wider mb-1">Last Updated</dt>
                    <dd class="font-ui-label text-ui-label text-on-surface">{{ $role->updated_at->format('M d, Y · H:i') }}
                    </dd>
                </div>
            </dl>
        </div>

    </div>
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
    </style>
@endpush
