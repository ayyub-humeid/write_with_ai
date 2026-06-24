
@extends('layouts.main')

@section('mainClass', 'pt-24 pb-section-gap max-w-container-max mx-auto px-gutter')
@section('bodyClass', 'font-body-md text-body-md selection:bg-primary-fixed selection:text-on-primary-fixed')

@section('content')
<div class="space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 pb-6 border-b border-outline-variant">
        <div>
            <p class="font-metadata text-metadata text-secondary uppercase tracking-widest mb-1">Administration</p>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Users</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                Manage user accounts and assign roles.
            </p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            <span class="font-ui-label text-ui-label">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Users Table --}}
    <div class="bg-white border border-outline-variant rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-outline-variant bg-surface-container/30">
                        <th class="text-left px-6 py-4 font-ui-label text-ui-label text-secondary uppercase tracking-wider">User</th>
                        <th class="text-left px-6 py-4 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Email</th>
                        <th class="text-left px-6 py-4 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Type</th>
                        <th class="text-left px-6 py-4 font-ui-label text-ui-label text-secondary uppercase tracking-wider">Role</th>
                        <th class="text-left px-6 py-4 font-ui-label text-ui-label text-secondary uppercase tracking-wider hidden sm:table-cell">Joined</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse($users as $user)
                        <tr class="group hover:bg-surface-container/20 transition-colors">
                            {{-- User Name & Avatar --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->gravatar_url }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-full object-cover">
                                    <div>
                                        <p class="font-ui-label text-ui-label font-bold text-on-surface">{{ $user->name }}</p>
                                        <p class="font-metadata text-metadata text-secondary">{{ '@'.$user->username }}</p>
                                    </div>
                                </div>
                            </td>
                            {{-- Email --}}
                            <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">
                                {{ $user->email }}
                            </td>
                            {{-- Type --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $user->type === 'super-admin' ? 'bg-red-100 text-red-700' : ($user->type === 'admin' ? 'bg-amber-100 text-amber-700' : 'bg-surface-container text-secondary') }}">
                                    {{ ucfirst($user->type) }}
                                </span>
                            </td>
                            {{-- Role --}}
                            <td class="px-6 py-4">
                                @if($user->role)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-primary-container/20 text-primary">
                                        <span class="material-symbols-outlined text-[12px]">shield_person</span>
                                        {{ $user->role->name }}
                                    </span>
                                @else
                                    <span class="text-outline text-xs">No Role</span>
                                @endif
                            </td>
                            {{-- Joined At --}}
                            <td class="px-6 py-4 hidden sm:table-cell">
                                <span class="font-metadata text-metadata text-secondary">
                                    {{ $user->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            {{-- Actions --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1 justify-end opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        title="Edit Role"
                                        class="p-2 rounded-lg text-secondary hover:text-primary hover:bg-primary-container/10 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <p class="text-on-surface-variant">No users found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-outline-variant flex items-center justify-between">
                <p class="font-metadata text-metadata text-secondary">
                    Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
                </p>
                <div class="flex items-center gap-1">
                    {{ $users->links() }}
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
</style>
@endpush
