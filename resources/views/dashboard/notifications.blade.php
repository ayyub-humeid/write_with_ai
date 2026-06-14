@extends('layouts.main')
@section('title', 'Notifications')
@section('content')
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 animate-fade-in-up">
        <div>
            <h1 class="pt-16 font-display-lg text-display-lg text-on-background mb-2">Notifications</h1>
            <p class="text-on-surface-variant max-w-lg font-ui-label text-ui-label">
                Stay updated with the latest interactions, comments, and milestones in your writing journey.
            </p>
        </div>
        <div class="flex gap-4">
            @if ($unread_count > 0)
                <form action="{{ route('dashboard.notifications.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-primary-container text-on-primary px-6 py-3 rounded-lg font-ui-button text-ui-button flex items-center gap-2 hover:opacity-90 active:scale-95 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">done_all</span>
                        Mark all as read
                    </button>
                </form>
            @endif
            <button
                class="bg-surface-container-high text-on-surface px-6 py-3 rounded-lg font-ui-button text-ui-button flex items-center gap-2 hover:bg-outline-variant transition-all">
                <span class="material-symbols-outlined text-[20px]">filter_list</span>
                Filter
            </button>
        </div>
    </div>

    <!-- Dashboard Layout Grid -->
    <div class="grid grid-cols-12 gap-8">
        <!-- Sidebar / Stats -->
        @include('dashboard.posts.includes.aside')

        <!-- Main Content Area -->
        <div class="col-span-12 lg:col-span-9 space-y-6">
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant overflow-hidden shadow-sm">
                <!-- Tabs for filtering -->
                <div class="flex border-b border-outline-variant bg-surface-container-lowest">
                    <a href="{{ route('dashboard.notifications.index', ['status' => 'all']) }}"
                        class="px-8 py-4 text-ui-label font-ui-label font-semibold {{ $status === 'all' ? 'text-primary border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary' }} transition-all">
                        All Activity
                    </a>
                    <a href="{{ route('dashboard.notifications.index', ['status' => 'unread']) }}"
                        class="px-8 py-4 text-ui-label font-ui-label font-semibold {{ $status === 'unread' ? 'text-primary border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary' }} transition-all relative">
                        Unread
                        @if ($unread_count > 0)
                            <span class="ml-2 bg-primary/10 text-primary text-[10px] px-1.5 py-0.5 rounded-full font-bold">
                                {{ $unread_count }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Notifications List -->
                <div class="divide-y divide-outline-variant">
                    @forelse($notifications as $notification)
                        <div
                            class="group relative flex items-start gap-4 p-6 hover:bg-surface-container-low transition-all @if (!$notification->read_at) bg-primary-fixed/10 @endif">
                            <!-- Unread Indicator -->
                            @if (!$notification->read_at)
                                <div class="absolute left-2 top-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-primary rounded-full">
                                </div>
                            @endif

                            <!-- Icon/Avatar -->
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 rounded-full overflow-hidden bg-surface-container flex items-center justify-center border border-outline-variant">
                                    @php
                                        $icon = 'notifications';
                                        $color = 'text-outline';
                                        $data = $notification->data;

                                        if (str_contains($notification->type, 'Follow')) {
                                            $icon = 'person_add';
                                            $color = 'text-primary';
                                        } elseif (str_contains($notification->type, 'Comment')) {
                                            $icon = 'chat_bubble';
                                            $color = 'text-tertiary';
                                        } elseif (str_contains($notification->type, 'Like')) {
                                            $icon = 'favorite';
                                            $color = 'text-error';
                                        }
                                    @endphp
                                    <span class="material-symbols-outlined {{ $color }}">{{ $icon }}</span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-grow min-w-0">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="text-ui-label font-ui-label text-on-surface leading-snug">
                                        @if (isset($data['title']))
                                            {!! $data['title'] !!}
                                        @else
                                            <span class="font-bold">System</span> notified you about something.
                                        @endif
                                    </div>
                                    <time class="text-metadata font-metadata text-outline flex-shrink-0 whitespace-nowrap">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </time>
                                </div>

                                @if (isset($data['body']))
                                    <p class="mt-2 text-ui-label text-on-surface-variant line-clamp-2 text-sm">
                                        {{ $data['body'] }}
                                    </p>
                                @endif

                                @if (isset($data['content_preview']))
                                    <p class="mt-2 text-ui-label text-on-surface-variant line-clamp-2 italic text-sm">
                                        "{{ $data['content_preview'] }}"
                                    </p>
                                @endif

                                <!-- Actions -->
                                <div
                                    class="mt-4 flex items-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @if (!$notification->read_at)
                                        <form action="{{ route('dashboard.notifications.read', $notification->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-metadata font-ui-label font-semibold text-primary hover:underline">
                                                Mark as read
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('dashboard.notifications.unread', $notification->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-metadata font-ui-label font-semibold text-on-surface-variant hover:underline">
                                                Mark as unread
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('dashboard.notifications.destroy', $notification->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-metadata font-ui-label font-semibold text-error hover:underline">
                                            Delete
                                        </button>
                                    </form>

                                    @if(isset($data['meta']['follower_id']) && $data['meta']['follower_id'] != auth()->id())
                                        @php $followerId = $data['meta']['follower_id']; @endphp
                                        <button id="follow-btn-{{ $followerId }}"
                                            onclick="{{ Auth::user()->followings->contains($followerId) ? "unfollow($followerId)" : "follow($followerId)" }}"
                                            class="text-metadata font-ui-label font-semibold text-primary hover:underline transition-all">
                                            {{ Auth::user()->followings->contains($followerId) ? 'Unfollow' : 'Follow back' }}
                                        </button>
                                    @endif

                                    @if (isset($data['link']))
                                        <a href="{{ $data['link'] }}"
                                            class="text-metadata font-ui-label font-semibold text-secondary hover:underline">
                                            View Profile
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-20 px-6 text-center animate-fade-in">
                            <div class="w-24 h-24 bg-surface-container rounded-full flex items-center justify-center mb-6">
                                <span
                                    class="material-symbols-outlined text-[48px] text-outline opacity-30">notifications_off</span>
                            </div>
                            <h3 class="text-headline-md font-headline-md text-on-surface mb-2">All Caught Up!</h3>
                            <p class="text-on-surface-variant max-w-xs font-ui-label">
                                You don't have any notifications right now. We'll let you know when something happens.
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Footer/Pagination -->
                @if ($notifications->hasPages())
                    <div class="p-6 bg-surface-container-low border-t border-outline-variant">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('mainClass', 'flex-grow w-full max-w-container-max mx-auto px-gutter py-12')
@section('bodyClass', 'bg-surface text-on-surface min-h-screen flex flex-col font-body-md')

@push('style')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .group:hover .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }
    </style>
@endpush
