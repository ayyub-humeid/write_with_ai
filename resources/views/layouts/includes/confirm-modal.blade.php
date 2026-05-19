<!-- Modern Confirmation Modal Backdrop -->
<div id="confirm-modal-backdrop" class="fixed inset-0 z-[10000] bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
    <!-- Modal Card Container -->
    <div id="confirm-modal-card" class="bg-white rounded-2xl shadow-2xl border border-slate-100 max-w-md w-full p-6 transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col gap-5">
        <!-- Header Body -->
        <div class="flex items-start gap-4">
            <div id="confirm-modal-icon-container" class="flex-shrink-0 p-2.5 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px] font-bold" id="confirm-modal-icon">delete</span>
            </div>
            <div class="flex-grow pt-0.5">
                <h3 id="confirm-modal-title" class="text-lg font-bold text-slate-800">Delete Post</h3>
                <p id="confirm-modal-message" class="text-sm text-slate-500 mt-1.5 leading-relaxed">Are you sure you want to delete this post? This action cannot be undone.</p>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <button id="confirm-modal-cancel" class="px-4 py-2 border border-slate-200 rounded-lg font-ui-button text-ui-label text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all active:scale-[0.98]">
                Cancel
            </button>
            <button id="confirm-modal-submit" class="px-5 py-2 bg-error text-on-error rounded-lg font-ui-button text-ui-label hover:opacity-90 transition-all active:scale-[0.98]">
                Delete
            </button>
        </div>
    </div>
</div>

<script>
    /**
     * Display a modern, promise-based confirmation dialog.
     * @param {Object} options Configuration parameters.
     * @param {string} options.title The title of the modal.
     * @param {string} options.message The main message details.
     * @param {string} options.confirmText The label for the submit button.
     * @param {string} options.cancelText The label for the cancel button.
     * @param {string} options.type The severity type: 'danger' (red), 'info' (primary/purple), 'warning' (amber).
     * @returns {Promise<boolean>} Resolves to true on confirm, false on cancel/escape.
     */
    function showConfirmModal({
        title = 'Confirm Action',
        message = 'Are you sure you want to proceed?',
        confirmText = 'Confirm',
        cancelText = 'Cancel',
        type = 'danger'
    } = {}) {
        const backdrop = document.getElementById('confirm-modal-backdrop');
        const card = document.getElementById('confirm-modal-card');
        const titleEl = document.getElementById('confirm-modal-title');
        const messageEl = document.getElementById('confirm-modal-message');
        const cancelBtn = document.getElementById('confirm-modal-cancel');
        const submitBtn = document.getElementById('confirm-modal-submit');
        const iconEl = document.getElementById('confirm-modal-icon');
        const iconContainer = document.getElementById('confirm-modal-icon-container');

        if (!backdrop || !card) return Promise.resolve(false);

        // Populate details
        titleEl.textContent = title;
        messageEl.textContent = message;
        cancelBtn.textContent = cancelText;
        submitBtn.textContent = confirmText;

        // Customise color themes dynamically based on type
        if (type === 'danger') {
            iconEl.textContent = 'delete_forever';
            iconContainer.className = 'flex-shrink-0 p-2.5 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center';
            submitBtn.className = 'px-5 py-2 bg-error text-on-error rounded-lg font-ui-button text-ui-label hover:opacity-95 transition-all active:scale-[0.98] shadow-sm';
        } else if (type === 'warning') {
            iconEl.textContent = 'warning';
            iconContainer.className = 'flex-shrink-0 p-2.5 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center';
            submitBtn.className = 'px-5 py-2 bg-amber-500 text-white rounded-lg font-ui-button text-ui-label hover:bg-amber-600 transition-all active:scale-[0.98] shadow-sm';
        } else {
            iconEl.textContent = 'info';
            iconContainer.className = 'flex-shrink-0 p-2.5 rounded-xl bg-violet-50 text-primary flex items-center justify-center';
            submitBtn.className = 'px-5 py-2 bg-primary text-on-primary rounded-lg font-ui-button text-ui-label hover:opacity-95 transition-all active:scale-[0.98] shadow-sm';
        }

        // Return the promise that will resolve asynchronously on user action
        return new Promise((resolve) => {
            const cleanupAndResolve = (result) => {
                // Trigger exit animation
                card.classList.add('scale-95', 'opacity-0');
                backdrop.classList.add('opacity-0');
                backdrop.classList.add('pointer-events-none');

                // Cleanup listeners to prevent memory leaks
                cancelBtn.removeEventListener('click', handleCancel);
                submitBtn.removeEventListener('click', handleSubmit);
                backdrop.removeEventListener('click', handleOverlayClick);
                document.removeEventListener('keydown', handleEscKey);

                setTimeout(() => {
                    resolve(result);
                }, 300);
            };

            const handleCancel = () => cleanupAndResolve(false);
            const handleSubmit = () => cleanupAndResolve(true);
            
            const handleOverlayClick = (e) => {
                if (e.target === backdrop) cleanupAndResolve(false);
            };

            const handleEscKey = (e) => {
                if (e.key === 'Escape') cleanupAndResolve(false);
            };

            // Register Event Listeners
            cancelBtn.addEventListener('click', handleCancel);
            submitBtn.addEventListener('click', handleSubmit);
            backdrop.addEventListener('click', handleOverlayClick);
            document.addEventListener('keydown', handleEscKey);

            // Open Modal & slide card up
            backdrop.classList.remove('pointer-events-none', 'opacity-0');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
            }, 10);
        });
    }
</script>
