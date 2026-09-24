<div
    x-data="{
        open: false,
        title: 'Confirm Action',
        message: 'Are you sure you want to proceed? This action cannot be undone.',
        confirmText: 'Delete',
        cancelText: 'Cancel',
        confirmColor: 'red',
        action: null,
        isProcessing: false,
        
        handleConfirmEvent(detail) {
            if (!detail) return;
            this.title = detail.title || 'Confirm Action';
            this.message = detail.message || 'Are you sure you want to proceed? This action cannot be undone.';
            this.confirmText = detail.confirmText || 'Delete';
            this.cancelText = detail.cancelText || 'Cancel';
            this.confirmColor = detail.confirmColor || (this.confirmText.toLowerCase().includes('delete') ? 'red' : 'blue');
            this.action = detail.action || null;
            this.isProcessing = false;
            this.open = true;
        },
        
        async executeAction() {
            if (this.isProcessing) return;
            this.isProcessing = true;
            try {
                if (typeof this.action === 'function') {
                    const result = this.action();
                    if (result instanceof Promise) {
                        await result;
                    }
                } else if (typeof this.action === 'string') {
                    eval(this.action);
                }
            } catch (error) {
                console.error('Confirmation action error:', error);
            } finally {
                this.isProcessing = false;
                this.close();
            }
        },
        
        close() {
            this.open = false;
            this.action = null;
            this.isProcessing = false;
        }
    }"
    @confirm-action.window="handleConfirmEvent($event.detail)"
    @keydown.escape.window="if (open && !isProcessing) close()"
    x-cloak
    style="display: none;"
    x-show="open"
    class="fixed inset-0 z-[99999] overflow-y-auto"
    aria-labelledby="confirm-modal-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop overlay -->
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="if (!isProcessing) close()"
        class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs transition-opacity"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <!-- Modal Card -->
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 p-6"
            @click.stop
        >
            <div class="sm:flex sm:items-start">
                <!-- Icon -->
                <div
                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10"
                    :class="{
                        'bg-red-100 text-red-600': confirmColor === 'red',
                        'bg-amber-100 text-amber-600': confirmColor === 'amber' || confirmColor === 'yellow',
                        'bg-blue-100 text-blue-600': confirmColor === 'blue',
                        'bg-green-100 text-green-600': confirmColor === 'green',
                    }"
                >
                    <template x-if="confirmColor === 'red'">
                        <i class="fas fa-trash-alt text-base sm:text-sm"></i>
                    </template>
                    <template x-if="confirmColor === 'amber' || confirmColor === 'yellow'">
                        <i class="fas fa-exclamation-triangle text-base sm:text-sm"></i>
                    </template>
                    <template x-if="confirmColor === 'blue'">
                        <i class="fas fa-question-circle text-base sm:text-sm"></i>
                    </template>
                    <template x-if="confirmColor === 'green'">
                        <i class="fas fa-check-circle text-base sm:text-sm"></i>
                    </template>
                </div>

                <!-- Text Content -->
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left flex-1">
                    <h3 class="text-base font-bold text-gray-900 leading-6" id="confirm-modal-title" x-text="title"></h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 leading-relaxed" x-text="message"></p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 sm:mt-5 sm:flex sm:flex-row-reverse sm:gap-3">
                <!-- Confirm Button -->
                <button
                    type="button"
                    @click="executeAction()"
                    :disabled="isProcessing"
                    class="inline-flex w-full justify-center items-center rounded-xl px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all sm:w-auto focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    :class="{
                        'bg-red-600 hover:bg-red-700 focus:ring-red-500': confirmColor === 'red',
                        'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500': confirmColor === 'amber' || confirmColor === 'yellow',
                        'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500': confirmColor === 'blue',
                        'bg-green-600 hover:bg-green-700 focus:ring-green-500': confirmColor === 'green',
                    }"
                >
                    <template x-if="isProcessing">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="isProcessing ? 'Processing...' : confirmText"></span>
                </button>

                <!-- Cancel Button -->
                <button
                    type="button"
                    @click="close()"
                    :disabled="isProcessing"
                    class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-xs ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors sm:mt-0 sm:w-auto disabled:opacity-50"
                    x-text="cancelText"
                ></button>
            </div>
        </div>
    </div>
</div>

<script>
    if (!window.confirmAction) {
        window.confirmAction = function(options) {
            window.dispatchEvent(new CustomEvent('confirm-action', { detail: options }));
        };
    }
    if (!window.confirmDelete) {
        window.confirmDelete = function(action, title = 'Delete Confirmation', message = 'Are you sure you want to delete this? This action cannot be undone.') {
            window.dispatchEvent(new CustomEvent('confirm-action', {
                detail: {
                    title: title,
                    message: message,
                    confirmText: 'Delete',
                    confirmColor: 'red',
                    action: action
                }
            }));
        };
    }
</script>
