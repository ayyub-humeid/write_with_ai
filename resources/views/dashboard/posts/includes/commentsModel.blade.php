<div id="commentsModal"
    class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-[2px] items-center justify-center p-4 transition-opacity duration-200">
    <div
        class="bg-white w-full max-w-2xl rounded-2xl border border-gray-200 shadow-2xl flex flex-col max-h-[85vh] overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <h3 class="font-headline-md text-[18px] font-semibold text-gray-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[20px]">chat_bubble</span>
                    Post comments
                </h3>
                <p id="commentsMeta" class="text-[12px] text-gray-500 mt-1"></p>
            </div>
            <button onclick="closeCommentsModal()"
                class="p-2 hover:bg-gray-100 rounded-lg text-gray-500 transition-colors"
                aria-label="Close comments modal">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div id="commentsLoader" class="hidden px-5 py-6 text-sm text-gray-500">Loading comments...</div>

        <div id="commentsList" class="px-5 py-4 overflow-y-auto flex-grow space-y-3 min-h-[220px] bg-gray-50/60"></div>
    </div>
</div>
