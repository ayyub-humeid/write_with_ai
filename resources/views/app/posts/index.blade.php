@extends('layouts.main')
@section('content')

    <!-- Left Sidebar: Navigation & Tags -->
    @include('layouts.includes.left-aside')
    <!-- Center Feed -->
    <section class="col-span-1 md:col-span-7 space-y-12">
        <!-- Featured Article (Bento Style) -->
        <article
            class="group border border-outline-variant rounded-xl overflow-hidden bg-white hover:border-primary transition-colors duration-300">
            <div class="aspect-[16/9] overflow-hidden">
                <img alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                    data-alt="A macro photograph of high-quality cream-colored paper with deep black ink strokes, showcasing fine texture and professional calligraphy. The lighting is soft and cinematic, casting gentle shadows that emphasize the physical depth of the ink on the page. The overall aesthetic is minimalist and sophisticated, representing a premium editorial experience with high contrast and clarity."
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBBFBSyj6CkyvBOD_SRQ5A-cSY1Cdw5WCfpcpMbK6wt1gNKpKVEBIHZC_rRMCEvC8iTE1zTEYRtsP81jrHP0bo9ffojhdYOzgAhgs1Cz0q8QFqa0nSD_IfSMhW9ztTCe15twvtGHZkIn0PtjzGAqIbQpqDXsAI-wV5oooi_CA4cwuHj96Y1K7UbHK1q_5sWUMDjows8tWRxj4iMYvIBUd-ops3T519EOJ6RlLxzk1jn0Wtk_8HWTjpj__S_xDppqNI1tnhqIX3QSUad" />
            </div>
            <div class="p-8 space-y-4">
                <div class="flex items-center gap-3 font-metadata text-metadata text-secondary">
                    <span
                        class="bg-primary-container text-on-primary px-2 py-0.5 rounded font-bold uppercase tracking-wider">Featured</span>
                    <span>•</span>
                    <span>May 12, 2024</span>
                    <span>•</span>
                    <span>8 min read</span>
                </div>
                <h2
                    class="font-headline-md text-headline-md text-on-surface leading-tight group-hover:text-primary transition-colors">
                    The Architecture of Quiet: Why Minimalist Design Wins the Long Game</h2>
                <p class="text-on-surface-variant font-body-md text-body-md line-clamp-3">In an era of digital
                    noise, the most powerful statement a brand can make is silence. We explore the structural
                    psychology behind 'Paper &amp; Ink' aesthetics and how whitespace drives user focus in SaaS
                    environments.</p>
                <div class="flex items-center justify-between pt-4 border-t border-outline-variant">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant overflow-hidden">
                            <img alt="Author" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDlYHQ2yPKl-Weyq3JRVjhy936Wd9AaAVvFRAHsIQrKrnCv4i5A-cQ6YF0zqrKz1Ma7N9cW9R6NimpSIUyDmkSyzdN0Sf4wwyS7Jf5Iq_UrWBpwB9MPN5QGbUNdxa82Mz2YU2I0GnXGjM6DDPi-mIODcm-LUOTsZb-C7V1GgUyP3AvuztsY0A5OKbR2TsqCVVxpF70-TiHMB2Jsyd2ojVnbA0gj9jJ03QY9BqD7puDZnBBYI5PyKBtwtQiGWMcknmNIjCWUWokSAMSR" />
                        </div>
                        <div>
                            <p class="font-ui-label text-ui-label font-bold text-on-surface">Julian Thorne</p>
                            <p class="font-metadata text-metadata text-secondary">Design Principal</p>
                        </div>
                    </div>
                    <button class="text-primary p-2 rounded-full hover:bg-primary-container/10 transition-colors">
                        <span class="material-symbols-outlined" data-icon="bookmark_add">bookmark_add</span>
                    </button>
                </div>
            </div>
        </article>
        <!-- Grid of Regular Articles -->
        <div class="grid grid-cols-1 gap-12">
            <x-app-posts-list :posts="$posts" />

        </div>
        <div class="pt-8 flex justify-center">
            <button
                class="px-8 py-3 border border-primary text-primary font-ui-button text-ui-button rounded-lg hover:bg-primary-container/5 transition-all">
                Load More Stories
            </button>
        </div>
    </section>
    <!-- Right Sidebar: Trending & Who to Follow -->
    @include('layouts.includes.right-aside')
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
@section('mainClass',
    'pt-24 pb-section-gap max-w-container-max mx-auto px-gutter grid grid-cols-1 md:grid-cols-12
    gap-8')
@section('bodyClass', 'font-body-md text-body-md selection:bg-primary-fixed selection:text-on-primary-fixed')
