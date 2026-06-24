
@extends('layouts.main')

@section('mainClass', 'pt-24 pb-section-gap max-w-container-max mx-auto px-gutter')
@section('bodyClass', 'font-body-md text-body-md selection:bg-primary-fixed selection:text-on-primary-fixed')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex items-center gap-4 pb-6 border-b border-outline-variant">
        <a href="{{ route('admin.users.index') }}" class="p-2 rounded-full hover:bg-surface-container/50 transition-colors">
            <span class="material-symbols-outlined text-secondary">arrow_back</span>
        </a>
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Manage User: {{ $user->name }}</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                Update account type and assign a dynamic role.
            </p>
        </div>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white border border-outline-variant rounded-xl p-8 space-y-8">
        @csrf
        @method('PUT')

        {{-- User Info --}}
        <div class="flex items-center gap-4 p-4 bg-surface-container/20 rounded-lg">
            <img src="{{ $user->gravatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full border-2 border-white shadow-sm">
            <div>
                <p class="font-ui-label text-ui-label font-bold text-on-surface">{{ $user->name }}</p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $user->email }}</p>
                <p class="font-metadata text-metadata text-secondary mt-1">Joined {{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Account Type --}}
            <div class="space-y-2">
                <label for="type" class="block font-ui-label text-ui-label font-bold text-on-surface">Account Type</label>
                <p class="font-metadata text-metadata text-secondary mb-2">Internal system level classification.</p>
                <select name="type" id="type" class="w-full bg-surface-container/30 border border-outline rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                    <option value="user" {{ $user->type === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->type === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super-admin" {{ $user->type === 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('type') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Dynamic Role --}}
            <div class="space-y-2">
                <label for="role_id" class="block font-ui-label text-ui-label font-bold text-on-surface">Dynamic Role</label>
                <p class="font-metadata text-metadata text-secondary mb-2">Assign specific abilities from the roles table.</p>
                <select name="role_id" id="role_id" class="w-full bg-surface-container/30 border border-outline rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                    <option value="">None (Standard permissions)</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-4 border-t border-outline-variant flex justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 rounded-lg font-ui-label text-ui-label text-on-surface hover:bg-surface-container/50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-primary text-on-primary px-8 py-2.5 rounded-lg font-ui-label text-ui-label hover:bg-primary-hover transition-all shadow-sm active:scale-95">
                Save Changes
            </button>
        </div>
    </form>

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
