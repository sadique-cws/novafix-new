<div class="mx-auto mt-5 overflow-hidden rounded-lg bg-white shadow-md">
    <livewire:admin.components.navigation />

    <div class="flex flex-col gap-3 bg-[#1E40AF] px-4 py-3 text-[#F9FAFB] sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-xl font-medium">Fault Diagnosis Flow Studio</h3>
            <p class="text-sm text-blue-100">Copy full question sub-flows from any node and reuse them across problems.</p>
        </div>
        <button
            wire:click="loadTree"
            class="rounded-md bg-white px-3 py-1 text-sm font-medium text-blue-600 transition-colors hover:bg-blue-50"
            type="button"
        >
            Refresh
        </button>
    </div>

    @if (session()->has('message'))
        <div class="m-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-800">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="m-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="border-b p-4">
        <div class="mb-2 text-sm font-semibold text-gray-800">Target Flow</div>
        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Device</label>
                <select
                    wire:model.live="selectedDevice"
                    class="w-full rounded-md border border-gray-300 p-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    wire:loading.attr="disabled"
                    wire:target="selectedDevice"
                >
                    <option value="">Choose device</option>
                    @foreach ($devices as $device)
                        <option value="{{ $device->id }}">{{ $device->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Brand</label>
                <select
                    wire:model.live="selectedBrand"
                    class="w-full rounded-md border border-gray-300 p-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    @disabled(!$selectedDevice)
                    wire:loading.attr="disabled"
                    wire:target="selectedDevice,selectedBrand"
                >
                    <option value="">{{ $selectedDevice ? 'Choose brand' : 'Select device first' }}</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Model</label>
                <select
                    wire:model.live="selectedModel"
                    class="w-full rounded-md border border-gray-300 p-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    @disabled(!$selectedBrand)
                    wire:loading.attr="disabled"
                    wire:target="selectedBrand,selectedModel"
                >
                    <option value="">{{ $selectedBrand ? 'Choose model' : 'Select brand first' }}</option>
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Problem</label>
                <select
                    wire:model.live="selectedProblem"
                    class="w-full rounded-md border border-gray-300 p-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    @disabled(!$selectedModel)
                    wire:loading.attr="disabled"
                    wire:target="selectedModel,selectedProblem"
                >
                    <option value="">{{ $selectedModel ? 'Choose problem' : 'Select model first' }}</option>
                    @foreach ($problems as $problem)
                        <option value="{{ $problem->id }}">{{ $problem->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div
            wire:loading.flex
            wire:target="selectedDevice,selectedBrand,selectedModel,selectedProblem,loadTree"
            class="mt-3 items-center gap-2 rounded-md border border-blue-100 bg-blue-50 px-3 py-2 text-xs text-blue-700"
        >
            <span class="h-3 w-3 animate-spin rounded-full border-2 border-blue-300 border-t-blue-700"></span>
            Updating flow options...
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 p-4 xl:grid-cols-3">
        <div
            class="rounded-lg border border-gray-200 bg-gray-50 p-4 xl:col-span-2"
            x-data="treeExplorer(@js($tree), @entangle('selectedTreeNodeId'))"
            x-init="init()"
            x-ref="treePanel"
            :class="isFullscreen ? 'fixed inset-0 z-50 m-0 overflow-auto rounded-none border-0 bg-white p-3' : ''"
        >
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div class="text-sm font-semibold text-gray-800">
                    Tree Viewer
                    @if($tree['problem'])
                        <span class="font-normal text-gray-500">- {{ $tree['problem']['name'] }}</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500">{{ $tree['count'] }} questions</span>
                    <button
                        type="button"
                        @click="toggleFullscreen()"
                        class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50"
                        wire:loading.attr="disabled"
                        wire:target="selectedProblem,loadTree"
                        x-text="isFullscreen ? 'Exit Full Screen' : 'Full Screen'"
                        :aria-label="isFullscreen ? 'Exit full screen tree view' : 'Open full screen tree view'"
                    ></button>
                </div>
            </div>

            <div class="mt-2 rounded-md border border-gray-200 bg-white p-2 text-[11px] text-gray-600">
                Quick access: Press <span class="font-semibold">/</span> to search node, <span class="font-semibold">F</span> for full screen, and <span class="font-semibold">Esc</span> to exit.
            </div>

            @if($tree['count'] === 0)
                <div class="mt-4 text-sm text-gray-600">Select a problem to load tree.</div>
            @else
                <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="mr-2 inline-flex overflow-hidden rounded-md border border-gray-300 bg-white">
                            <button
                                type="button"
                                @click="switchView('d3')"
                                class="px-3 py-1.5 text-xs font-semibold"
                                :class="viewMode === 'd3' ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50'"
                            >
                                D3 Tree
                            </button>
                            <button
                                type="button"
                                @click="switchView('card')"
                                class="border-l border-gray-300 px-3 py-1.5 text-xs font-semibold"
                                :class="viewMode === 'card' ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50'"
                            >
                                Card Tree
                            </button>
                        </div>

                        <button type="button" @click="expandAll()" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                            Expand all
                        </button>
                        <button type="button" @click="collapseAll()" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                            Collapse all
                        </button>
                        <label class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs text-gray-700">
                            <input type="checkbox" x-model="compact" class="rounded border-gray-300" /> Compact
                        </label>
                        <label class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs text-gray-700">
                            <input type="checkbox" x-model="focusSelected" class="rounded border-gray-300" :disabled="!selectedNodeId" /> Focus selected
                        </label>
                    </div>

                    <div x-show="viewMode === 'd3'" class="flex items-center gap-2">
                        <button type="button" @click="zoomIn()" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">Zoom +</button>
                        <button type="button" @click="zoomOut()" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">Zoom -</button>
                        <button type="button" @click="zoomToSelected()" :disabled="!selectedNodeId" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 disabled:opacity-50">Zoom Node</button>
                        <button type="button" @click="resetZoom()" class="rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">Reset</button>
                    </div>
                </div>

                <div class="mt-3">
                    <label for="tree-search" class="mb-1 block text-xs font-medium text-gray-600">Search Node</label>
                    <input
                        id="tree-search"
                        type="text"
                        x-model="search"
                        x-ref="searchInput"
                        class="w-full rounded-md border border-gray-300 p-2 text-sm"
                        placeholder="Search node by id or text (shortcut: /)"
                    />
                </div>

                <template x-if="searchResults.length">
                    <div class="mt-2 rounded-md border border-gray-200 bg-white p-2">
                        <div class="mb-1 text-[11px] font-semibold uppercase tracking-wide text-gray-500">Quick jump</div>
                        <div class="flex max-h-28 flex-wrap gap-1 overflow-auto">
                            <template x-for="item in searchResults" :key="item.id">
                                <button
                                    type="button"
                                    @click="selectNode(item.id, true)"
                                    class="rounded bg-blue-50 px-2 py-1 text-xs text-blue-700 hover:bg-blue-100"
                                    x-text="`#${item.id}`"
                                ></button>
                            </template>
                        </div>
                    </div>
                </template>

                @if(count($tree['roots']) > 1)
                    <div class="mt-3 rounded-md border border-amber-200 bg-amber-50 p-2 text-xs text-amber-900">
                        Multiple roots detected ({{ count($tree['roots']) }}). Flow may be disconnected.
                    </div>
                @endif

                <div
                    x-show="viewMode === 'd3'"
                    x-ref="d3Wrap"
                    class="mt-3 overflow-hidden rounded-lg border border-gray-200 bg-white"
                    :class="isFullscreen ? 'max-h-[calc(100vh-170px)]' : 'max-h-[70vh]'"
                >
                    <svg x-ref="d3Svg" class="min-h-[380px] w-full cursor-grab active:cursor-grabbing" :class="isFullscreen ? 'h-[calc(100vh-150px)]' : 'h-[72vh]'"></svg>
                </div>

                <div
                    x-show="viewMode === 'card'"
                    class="mt-3 overflow-auto pr-1"
                    :class="isFullscreen ? 'max-h-[calc(100vh-170px)]' : 'max-h-[70vh]'"
                    @click="onTreeClick($event)"
                >
                    <template x-for="rootId in visibleRoots()" :key="`root-${rootId}`">
                        <div x-html="renderNode(rootId, 0)"></div>
                    </template>
                </div>
            @endif
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <div class="text-sm font-semibold text-gray-800">Clone / Reuse Sub-flow</div>
            <div class="mt-1 text-xs text-gray-600">Fast copy flow from any selected node and paste into YES/NO/root branch.</div>

            <div class="mt-3 rounded-md border border-blue-100 bg-blue-50 p-3 text-xs text-blue-900">
                Selected tree node:
                @if($selectedTreeNodeId)
                    <span class="font-semibold">#{{ $selectedTreeNodeId }}</span>
                @else
                    <span class="font-semibold">None</span>
                @endif
            </div>

            @if(!$canCloneFlow)
                <div class="mt-4 rounded-md border border-amber-200 bg-amber-50 p-3 text-sm text-amber-900">
                    Only admin can copy/clone question flows.
                </div>
            @else
            <div class="mt-4 space-y-4">
                <div class="rounded-md border border-gray-200 p-3">
                    <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Step 1: Choose Source</div>

                    <div class="mt-2 grid grid-cols-1 gap-2">
                        <button
                            type="button"
                            wire:click="useSelectedAsSource"
                            class="rounded-md border border-indigo-300 bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-100"
                            @disabled(!$selectedTreeNodeId || !$selectedProblem)
                        >
                            Use selected node as source start
                        </button>

                        <input
                            type="text"
                            wire:model.live.debounce.250ms="sourceSearch"
                            class="w-full rounded-md border border-gray-300 p-2 text-sm"
                            placeholder="Search source questions"
                        />
                    </div>

                    <div class="mt-3">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Source Problem</label>
                        <select wire:model.change="sourceProblemId" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                            <option value="">Choose source problem (default: current target problem)</option>
                            @foreach($allProblems as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-3">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Source Start Question</label>
                        <select wire:model.change="sourceQuestionId" class="w-full rounded-md border border-gray-300 p-2 text-sm" @disabled(!$sourceProblemId && !$selectedProblem)>
                            <option value="">Choose source question (or use selected node)</option>
                            @foreach($this->filteredSourceQuestions as $q)
                                <option value="{{ $q->id }}">#{{ $q->id }} - {{ \Illuminate\Support\Str::limit($q->question_text, 80) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="rounded-md border border-gray-200 p-3">
                    <div class="text-xs font-semibold uppercase tracking-wide text-gray-500">Step 2: Choose Target</div>

                    <div class="mt-2 grid grid-cols-2 gap-2">
                        <button
                            type="button"
                            wire:click="attachSelectedToYes"
                            class="rounded-md border border-green-300 bg-green-50 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-100"
                            @disabled(!$selectedTreeNodeId)
                        >
                            Paste to selected node YES
                        </button>
                        <button
                            type="button"
                            wire:click="attachSelectedToNo"
                            class="rounded-md border border-red-300 bg-red-50 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-100"
                            @disabled(!$selectedTreeNodeId)
                        >
                            Paste to selected node NO
                        </button>
                    </div>

                    <div class="mt-2">
                        <button
                            type="button"
                            wire:click="useSelectedAsAttachTarget"
                            class="w-full rounded-md border border-blue-300 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100"
                            @disabled(!$selectedTreeNodeId || $attachMode === 'root')
                        >
                            Use selected node as attach target
                        </button>
                    </div>

                    <div class="mt-3">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Attach Mode</label>
                        <select wire:model.change="attachMode" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                            <option value="yes">Attach to YES</option>
                            <option value="no">Attach to NO</option>
                            <option value="root">Set as ROOT (target must be empty)</option>
                        </select>
                    </div>

                    @if($attachMode !== 'root')
                        <div class="mt-3">
                            <input
                                type="text"
                                wire:model.live.debounce.250ms="targetSearch"
                                class="w-full rounded-md border border-gray-300 p-2 text-sm"
                                placeholder="Search target questions"
                            />
                        </div>

                        <div class="mt-3">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Attach To (Target Question)</label>
                            <select wire:model.change="targetAttachQuestionId" class="w-full rounded-md border border-gray-300 p-2 text-sm" @disabled(!$selectedProblem)>
                                <option value="">Choose target question (or use selected node)</option>
                                @foreach($this->filteredTargetQuestions as $q)
                                    <option value="{{ $q->id }}">#{{ $q->id }} - {{ \Illuminate\Support\Str::limit($q->question_text, 80) }}</option>
                                @endforeach
                            </select>
                            <div class="mt-1 text-xs text-gray-500">If empty, selected tree node is used automatically when available.</div>
                        </div>
                    @else
                        <div class="mt-3 rounded-md border border-gray-200 bg-gray-50 p-3 text-xs text-gray-600">
                            ROOT attach works only if target problem has no questions.
                        </div>
                    @endif
                </div>

                <button
                    wire:click="cloneFlow"
                    class="mt-1 w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 disabled:opacity-50"
                    @disabled(!$selectedProblem)
                    wire:loading.attr="disabled"
                    wire:target="cloneFlow"
                    type="button"
                >
                    <span wire:loading.remove wire:target="cloneFlow">Clone and Attach Flow</span>
                    <span wire:loading.inline-flex wire:target="cloneFlow" class="items-center gap-2">
                        <span class="h-3.5 w-3.5 animate-spin rounded-full border-2 border-white/60 border-t-white"></span>
                        Cloning...
                    </span>
                </button>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/d3@7"></script>
    <script>
        function treeExplorer(tree, selectedNodeId) {
            return {
                tree,
                selectedNodeId,
                expanded: {},
                search: '',
                compact: true,
                focusSelected: false,
                viewMode: 'd3',
                isFullscreen: false,
                zoomBehavior: null,
                currentTransform: d3.zoomIdentity,
                nodeCoords: {},
                contentSize: { width: 0, height: 0 },
                fullscreenListener: null,
                keydownListener: null,
                init() {
                    if (!this.selectedNodeId && this.tree.roots.length) {
                        this.selectedNodeId = this.tree.roots[0];
                        this.$wire.selectTreeNode(this.selectedNodeId);
                    }

                    this.$watch('selectedNodeId', () => {
                        if (this.viewMode === 'd3') this.$nextTick(() => this.renderD3());
                    });
                    this.$watch('search', () => {
                        if (this.viewMode === 'd3') this.$nextTick(() => this.renderD3());
                    });
                    this.$watch('focusSelected', () => {
                        if (this.viewMode === 'd3') this.$nextTick(() => this.renderD3());
                    });
                    this.$watch('viewMode', (mode) => {
                        if (mode === 'd3') this.$nextTick(() => this.renderD3());
                    });
                    this.$watch('tree', () => {
                        if (this.viewMode === 'd3') this.$nextTick(() => this.renderD3());
                    });
                    this.$watch('isFullscreen', () => {
                        if (this.viewMode === 'd3') this.$nextTick(() => this.renderD3());
                    });

                    this.fullscreenListener = () => {
                        this.syncFullscreenState();
                        if (this.viewMode === 'd3') this.$nextTick(() => this.renderD3());
                    };
                    this.keydownListener = (event) => this.handleGlobalShortcuts(event);

                    document.addEventListener('fullscreenchange', this.fullscreenListener);
                    window.addEventListener('keydown', this.keydownListener);

                    this.$nextTick(() => this.renderD3());
                },
                destroy() {
                    if (this.fullscreenListener) {
                        document.removeEventListener('fullscreenchange', this.fullscreenListener);
                    }
                    if (this.keydownListener) {
                        window.removeEventListener('keydown', this.keydownListener);
                    }
                },
                switchView(mode) {
                    this.viewMode = mode;
                },
                syncFullscreenState() {
                    this.isFullscreen = document.fullscreenElement === this.$refs.treePanel;
                },
                toggleFullscreen() {
                    const panel = this.$refs.treePanel;
                    if (!panel) return;

                    if (document.fullscreenElement === panel) {
                        document.exitFullscreen?.();
                        return;
                    }

                    panel.requestFullscreen?.();
                },
                handleGlobalShortcuts(event) {
                    const target = event.target;
                    const tagName = target?.tagName?.toLowerCase();
                    const isTyping = ['input', 'textarea', 'select'].includes(tagName) || target?.isContentEditable;

                    if (!isTyping && event.key === '/') {
                        event.preventDefault();
                        this.$refs.searchInput?.focus();
                        return;
                    }

                    if (!isTyping && (event.key === 'f' || event.key === 'F')) {
                        event.preventDefault();
                        this.toggleFullscreen();
                        return;
                    }

                    if (event.key === 'Escape' && this.isFullscreen) {
                        event.preventDefault();
                        document.exitFullscreen?.();
                    }
                },
                esc(str) {
                    return String(str ?? '')
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;');
                },
                isExpanded(id, depth) {
                    if (this.expanded[id] === undefined) return depth < 2;
                    return this.expanded[id];
                },
                toggleNode(id) {
                    this.expanded[id] = !this.isExpanded(id, 0);
                },
                expandAll() {
                    const next = {};
                    Object.values(this.tree.nodes || {}).forEach((node) => {
                        if (node?.yes || node?.no) next[node.id] = true;
                    });
                    this.expanded = next;
                },
                collapseAll() {
                    this.expanded = {};
                },
                selectNode(id, center = false) {
                    this.selectedNodeId = id;
                    this.$wire.selectTreeNode(id);
                    if (center && this.viewMode === 'd3') {
                        this.$nextTick(() => this.centerOnNode(id, 1.55));
                    }
                },
                visibleRoots() {
                    if (this.focusSelected && this.selectedNodeId && this.tree.nodes[this.selectedNodeId]) {
                        return [Number(this.selectedNodeId)];
                    }
                    return this.tree.roots || [];
                },
                onTreeClick(event) {
                    const button = event.target.closest('[data-tree-action]');
                    if (!button) return;

                    const action = button.getAttribute('data-tree-action');
                    const nodeId = Number(button.getAttribute('data-node-id'));
                    if (!nodeId) return;

                    if (action === 'toggle') this.toggleNode(nodeId);
                    if (action === 'select') this.selectNode(nodeId);
                },
                containsSearchInBranch(id, cache = {}) {
                    if (!this.search.trim()) return true;
                    if (cache[id] !== undefined) return cache[id];

                    const node = this.tree.nodes[id];
                    if (!node) {
                        cache[id] = false;
                        return false;
                    }

                    const q = this.search.toLowerCase();
                    const own = `${node.id} ${node.text ?? ''}`.toLowerCase().includes(q);
                    const yesMatch = node.yes ? this.containsSearchInBranch(node.yes, cache) : false;
                    const noMatch = node.no ? this.containsSearchInBranch(node.no, cache) : false;

                    cache[id] = own || yesMatch || noMatch;
                    return cache[id];
                },
                renderNode(id, depth, cache = {}) {
                    const node = this.tree.nodes[id];
                    if (!node) return '';
                    if (!this.containsSearchInBranch(id, cache)) return '';

                    const hasChildren = Boolean(node.yes || node.no);
                    const expanded = this.isExpanded(id, depth);
                    const selected = String(this.selectedNodeId) === String(id);
                    const left = depth * (this.compact ? 12 : 18);

                    const cardClass = this.compact
                        ? 'rounded-lg border bg-white px-2.5 py-2'
                        : 'rounded-xl border bg-white px-3 py-3';
                    const selectedClass = selected
                        ? 'border-indigo-400 ring-2 ring-indigo-100'
                        : 'border-gray-200 hover:border-gray-300';

                    const toggleButton = hasChildren
                        ? `<button type="button" data-tree-action="toggle" data-node-id="${node.id}" class="h-7 w-7 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">${expanded ? '-' : '+'}</button>`
                        : '<span class="inline-block h-7 w-7"></span>';

                    const card = `
                        <div class="mt-1.5" style="margin-left:${left}px">
                            <div class="${cardClass} ${selectedClass} flex items-start gap-2">
                                ${toggleButton}
                                <button type="button" data-tree-action="select" data-node-id="${node.id}" class="min-w-0 flex-1 text-left">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-[11px] font-semibold text-gray-500">#${node.id}</span>
                                        <span class="min-w-0 flex-1 truncate text-sm font-semibold text-gray-900">${this.esc(node.text)}</span>
                                    </div>
                                    <div class="mt-1 flex flex-wrap gap-1.5 text-[11px]">
                                        <span class="rounded bg-green-50 px-2 py-1 text-green-700">Y -> ${node.yes ?? 'END'}</span>
                                        <span class="rounded bg-red-50 px-2 py-1 text-red-700">N -> ${node.no ?? 'END'}</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    `;

                    if (!hasChildren || !expanded) return card;

                    let children = '';
                    if (node.yes) {
                        children += `<div class="ml-1 mt-1 text-[11px] font-semibold text-green-700" style="margin-left:${left + (this.compact ? 16 : 24)}px">YES</div>`;
                        children += this.renderNode(node.yes, depth + 1, cache);
                    }
                    if (node.no) {
                        children += `<div class="ml-1 mt-1 text-[11px] font-semibold text-red-700" style="margin-left:${left + (this.compact ? 16 : 24)}px">NO</div>`;
                        children += this.renderNode(node.no, depth + 1, cache);
                    }

                    return card + children;
                },
                get searchResults() {
                    const q = this.search.trim().toLowerCase();
                    if (!q) return [];
                    return Object.values(this.tree.nodes || {})
                        .filter((node) => `${node.id} ${node.text ?? ''}`.toLowerCase().includes(q))
                        .slice(0, 24);
                },
                buildGraphNode(id, lineage = new Set(), branch = null) {
                    const node = this.tree.nodes?.[id];
                    if (!node) return null;

                    if (lineage.has(id)) {
                        return { id, text: `#${id} (cycle)`, branch, children: [] };
                    }

                    const nextLineage = new Set(lineage);
                    nextLineage.add(id);

                    const children = [];
                    if (node.yes) {
                        const yesNode = this.buildGraphNode(Number(node.yes), nextLineage, 'YES');
                        if (yesNode) children.push(yesNode);
                    }
                    if (node.no) {
                        const noNode = this.buildGraphNode(Number(node.no), nextLineage, 'NO');
                        if (noNode) children.push(noNode);
                    }

                    return { id: node.id, text: node.text ?? '', branch, children };
                },
                renderD3() {
                    const svgEl = this.$refs.d3Svg;
                    const wrapEl = this.$refs.d3Wrap;
                    if (!svgEl || !wrapEl || !window.d3) return;

                    const d3 = window.d3;
                    const svg = d3.select(svgEl);
                    svg.selectAll('*').remove();

                    const roots = this.visibleRoots();
                    if (!roots.length) return;

                    const graphChildren = roots.map((id) => this.buildGraphNode(Number(id))).filter(Boolean);
                    if (!graphChildren.length) return;

                    const root = d3.hierarchy({ id: 'root', text: 'Root', children: graphChildren });
                    d3.tree().nodeSize([56, 240])(root);

                    const points = root.descendants().filter((d) => d.data.id !== 'root');
                    if (!points.length) return;

                    const minX = Math.min(...points.map((d) => d.x));
                    const maxX = Math.max(...points.map((d) => d.x));
                    const levels = Math.max(...points.map((d) => d.depth));

                    const containerWidth = Math.max(900, wrapEl.clientWidth || 900);
                    const width = Math.max(containerWidth, levels * 240 + 460);
                    const height = Math.max(380, maxX - minX + 140);
                    const topPad = 50 - minX;
                    const leftPad = 70;

                    svg.attr('viewBox', `0 0 ${width} ${height}`);
                    svg.attr('preserveAspectRatio', 'xMinYMin meet');

                    const viewport = svg.append('g').attr('class', 'zoom-viewport');
                    const g = viewport.append('g').attr('transform', `translate(${leftPad},${topPad})`);

                    this.contentSize = { width, height };

                    const fitScale = Math.max(0.25, Math.min(1, (wrapEl.clientWidth - 24) / width));
                    const initialTransform = d3.zoomIdentity.translate(10, 10).scale(fitScale);

                    this.zoomBehavior = d3
                        .zoom()
                        .scaleExtent([0.25, 2.5])
                        .filter((event) => {
                            if (event.type === 'wheel') return true;
                            return !event.button || event.button === 0;
                        })
                        .on('zoom', (event) => {
                            this.currentTransform = event.transform;
                            viewport.attr('transform', event.transform);
                        });

                    svg.call(this.zoomBehavior);
                    svg.call(this.zoomBehavior.transform, initialTransform);
                    svg.on('dblclick.zoom', null);

                    g.append('g')
                        .selectAll('path')
                        .data(root.links().filter((link) => link.source.data.id !== 'root'))
                        .join('path')
                        .attr('fill', 'none')
                        .attr('stroke-width', 2)
                        .attr('stroke', (d) => (d.target.data.branch === 'YES' ? '#16a34a' : '#dc2626'))
                        .attr(
                            'd',
                            d3
                                .linkHorizontal()
                                .x((d) => d.y)
                                .y((d) => d.x)
                        );

                    const q = String(this.search || '').trim().toLowerCase();
                    const coords = {};
                    points.forEach((d) => {
                        coords[String(d.data.id)] = { absX: leftPad + d.y, absY: topPad + d.x };
                    });
                    this.nodeCoords = coords;

                    const nodesG = g
                        .append('g')
                        .selectAll('g')
                        .data(points)
                        .join('g')
                        .attr('transform', (d) => `translate(${d.y},${d.x})`);

                    nodesG
                        .append('circle')
                        .attr('r', 8)
                        .attr('cursor', 'pointer')
                        .attr('fill', (d) => {
                            const isSelected = String(this.selectedNodeId) === String(d.data.id);
                            if (isSelected) return '#2563eb';
                            const hit = q && `${d.data.id} ${d.data.text}`.toLowerCase().includes(q);
                            return hit ? '#f59e0b' : '#ffffff';
                        })
                        .attr('stroke', (d) => (String(this.selectedNodeId) === String(d.data.id) ? '#1d4ed8' : '#475569'))
                        .attr('stroke-width', (d) => (String(this.selectedNodeId) === String(d.data.id) ? 2.5 : 1.5))
                        .on('click', (_, d) => this.selectNode(String(d.data.id)))
                        .on('dblclick', (_, d) => {
                            const id = String(d.data.id);
                            this.selectNode(id);
                            this.centerOnNode(id, 1.6);
                        });

                    nodesG
                        .append('text')
                        .attr('x', 14)
                        .attr('y', -3)
                        .style('font-size', '12px')
                        .style('font-weight', '700')
                        .style('fill', '#334155')
                        .text((d) => `#${d.data.id}`);

                    nodesG
                        .append('text')
                        .attr('x', 14)
                        .attr('y', 14)
                        .style('font-size', '12px')
                        .style('fill', '#0f172a')
                        .text((d) => {
                            const text = String(d.data.text || '');
                            return text.length > 44 ? `${text.slice(0, 44)}...` : text;
                        });

                    const branchItems = [];
                    points.forEach((d) => {
                        const modelNode = this.tree.nodes?.[d.data.id];
                        if (!modelNode) return;
                        if (modelNode.yes) {
                            branchItems.push({
                                key: `${d.data.id}-yes`,
                                targetId: String(modelNode.yes),
                                label: 'YES',
                                x: d.y + 124,
                                y: d.x - 14,
                                bg: '#dcfce7',
                                color: '#15803d',
                            });
                        }
                        if (modelNode.no) {
                            branchItems.push({
                                key: `${d.data.id}-no`,
                                targetId: String(modelNode.no),
                                label: 'NO',
                                x: d.y + 124,
                                y: d.x + 6,
                                bg: '#fee2e2',
                                color: '#b91c1c',
                            });
                        }
                    });

                    const branchG = g
                        .append('g')
                        .selectAll('g')
                        .data(branchItems)
                        .join('g')
                        .attr('transform', (d) => `translate(${d.x},${d.y})`);

                    branchG
                        .append('rect')
                        .attr('width', 44)
                        .attr('height', 16)
                        .attr('rx', 6)
                        .attr('fill', (d) => d.bg)
                        .attr('cursor', 'pointer')
                        .on('click', (_, d) => {
                            this.selectNode(d.targetId, true);
                            this.focusSelected = true;
                        });

                    branchG
                        .append('text')
                        .attr('x', 22)
                        .attr('y', 11.5)
                        .attr('text-anchor', 'middle')
                        .style('font-size', '10px')
                        .style('font-weight', '700')
                        .style('fill', (d) => d.color)
                        .style('pointer-events', 'none')
                        .text((d) => d.label);
                },
                centerOnNode(nodeId, targetScale = null) {
                    const svgEl = this.$refs.d3Svg;
                    const wrapEl = this.$refs.d3Wrap;
                    if (!svgEl || !wrapEl || !this.zoomBehavior) return;

                    const coords = this.nodeCoords[String(nodeId)];
                    if (!coords) return;

                    const currentScale = this.currentTransform?.k || 1;
                    const scale = targetScale || currentScale;
                    const tx = wrapEl.clientWidth / 2 - coords.absX * scale;
                    const ty = wrapEl.clientHeight / 2 - coords.absY * scale;
                    const transform = d3.zoomIdentity.translate(tx, ty).scale(scale);

                    d3.select(svgEl).transition().duration(220).call(this.zoomBehavior.transform, transform);
                },
                zoomIn() {
                    const svgEl = this.$refs.d3Svg;
                    if (!svgEl || !this.zoomBehavior) return;
                    d3.select(svgEl).transition().duration(180).call(this.zoomBehavior.scaleBy, 1.2);
                },
                zoomOut() {
                    const svgEl = this.$refs.d3Svg;
                    if (!svgEl || !this.zoomBehavior) return;
                    d3.select(svgEl).transition().duration(180).call(this.zoomBehavior.scaleBy, 0.85);
                },
                zoomToSelected() {
                    if (!this.selectedNodeId) return;
                    this.centerOnNode(this.selectedNodeId, 1.55);
                },
                resetZoom() {
                    const svgEl = this.$refs.d3Svg;
                    const wrapEl = this.$refs.d3Wrap;
                    if (!svgEl || !wrapEl || !this.zoomBehavior) return;

                    const fitScale = Math.max(0.25, Math.min(1, (wrapEl.clientWidth - 24) / Math.max(1, this.contentSize.width)));
                    const transform = d3.zoomIdentity.translate(10, 10).scale(fitScale);
                    d3.select(svgEl).transition().duration(220).call(this.zoomBehavior.transform, transform);
                },
            };
        }
    </script>
</div>
