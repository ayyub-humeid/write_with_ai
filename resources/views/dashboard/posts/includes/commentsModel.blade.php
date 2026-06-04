<div id="commentsModal"
    class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm items-center justify-center p-4 transition-all duration-300">
    <div
        class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden animate-fade-in">
        <!-- Header -->
        <div
            class="bg-gradient-to-r from-slate-50 to-gray-50 border-b border-gray-200 px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-xl">
                    <span class="material-symbols-outlined text-blue-600 text-[22px]">chat_bubble</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Comments</h3>
                    <p id="commentsMeta" class="text-xs text-gray-500 mt-0.5 font-medium"></p>
                </div>
            </div>
            <button onclick="closeCommentsModal()"
                class="p-2 hover:bg-gray-200 rounded-lg text-gray-600 transition-all duration-200 hover:scale-110"
                aria-label="Close comments modal">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <!-- Loading State -->
        <div id="commentsLoader" class="hidden px-6 py-12 flex flex-col items-center justify-center gap-4">
            <div class="relative w-10 h-10">
                <div class="absolute inset-0 bg-blue-200 rounded-full animate-pulse"></div>
                <div
                    class="absolute inset-0 border-4 border-transparent border-t-blue-600 border-r-blue-600 rounded-full animate-spin">
                </div>
            </div>
            <p class="text-sm text-gray-600 font-medium">Loading comments...</p>
        </div>

        <!-- Comments List -->
        <div id="commentsList" class="overflow-y-auto flex-grow px-6 py-5 space-y-3 bg-white/50"></div>
    </div>
</div>
