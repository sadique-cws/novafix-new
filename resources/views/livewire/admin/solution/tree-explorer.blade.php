<div class="mx-auto mt-5 overflow-hidden rounded-lg bg-white shadow-md">
    <livewire:admin.components.navigation />

    <div class="flex flex-col gap-3 bg-[#1E40AF] px-4 py-3 text-[#F9FAFB] sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-xl font-medium">Tree Explorer</h3>
            <p class="text-sm text-blue-100">Visualize question tree and clone sub-flow quickly.</p>
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
                    wire:model.change="selectedDevice"
                    class="w-full rounded-md border border-gray-300 p-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 {{ $selectedDevice ? 'cursor-not-allowed bg-gray-100' : '' }}"
                    {{ $selectedDevice ? 'disabled' : '' }}
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
                    wire:model.change="selectedBrand"
                    class="w-full rounded-md border border-gray-300 p-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 {{ $selectedBrand ? 'cursor-not-allowed bg-gray-100' : '' }}"
                    {{ $selectedBrand ? 'disabled' : '' }}
                >
                    <option value="">Choose brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Model</label>
                <select
                    wire:model.change="selectedModel"
                    class="w-full rounded-md border border-gray-300 p-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 {{ $selectedModel ? 'cursor-not-allowed bg-gray-100' : '' }}"
                    {{ $selectedModel ? 'disabled' : '' }}
                >
                    <option value="">Choose model</option>
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Problem</label>
                <select
                    wire:model.change="selectedProblem"
                    class="w-full rounded-md border border-gray-300 p-2 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 {{ $selectedProblem ? 'cursor-not-allowed bg-gray-100' : '' }}"
                    {{ $selectedProblem ? 'disabled' : '' }}
                >
                    <option value="">Choose problem</option>
                    @foreach ($problems as $problem)
                        <option value="{{ $problem->id }}">{{ $problem->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 p-4 xl:grid-cols-3">
        <div
            class="rounded-lg border border-gray-200 bg-gray-50 p-4 xl:col-span-2"
            x-data="treeExplorer(@js($tree), @entangle('selectedTreeNodeId'))"
            x-init="init()"
        >
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div class="text-sm font-semibold text-gray-800">
                    Tree Viewer
                    @if($tree['problem'])
                        <span class="font-normal text-gray-500">- {{ $tree['problem']['name'] }}</span>
                    @endif
                </div>
                <div class="text-xs text-gray-500">
                    {{ $tree['count'] }} questions
                </div>
            </div>

            @if($tree['count'] === 0)
                <div class="mt-4 text-sm text-gray-600">Select a problem to load tree.</div>
            @else
                <div class="mt-3 flex flex-wrap items-center gap-2">
                    <button type="button" @click="expandAll()" class="rounded border border-gray-300 bg-white px-2.5 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50">
                        Expand all
                    </button>
                    <button type="button" @click="collapseAll()" class="rounded border border-gray-300 bg-white px-2.5 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50">
                        Collapse all
                    </button>
                    <label class="inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-2.5 py-1 text-xs text-gray-700">
                        <input type="checkbox" x-model="compact" class="rounded border-gray-300" /> Compact
                    </label>
                    <label class="inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-2.5 py-1 text-xs text-gray-700">
                        <input type="checkbox" x-model="focusSelected" class="rounded border-gray-300" :disabled="!selectedNodeId" /> Focus selected
                    </label>
                </div>

                <div class="mt-3">
                    <input
                        type="text"
                        x-model="search"
                        class="w-full rounded-md border border-gray-300 p-2 text-sm"
                        placeholder="Search node by id or text"
                    />
                </div>

                <template x-if="searchResults.length">
                    <div class="mt-2 rounded-md border border-gray-200 bg-white p-2">
                        <div class="mb-1 text-[11px] font-semibold uppercase tracking-wide text-gray-500">Quick jump</div>
                        <div class="flex max-h-28 flex-wrap gap-1 overflow-auto">
                            <template x-for="item in searchResults" :key="item.id">
                                <button
                                    type="button"
                                    @click="selectNode(item.id)"
                                    class="rounded bg-blue-50 px-2 py-1 text-xs text-blue-700 hover:bg-blue-100"
                                    x-text="`#${item.id}`"
                                ></button>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="treeStats.maxDepth > 0">
                    <div class="mt-2 rounded-md border border-gray-200 bg-white p-3">
                        <div class="flex items-center justify-between gap-2">
                            <div class="text-[11px] font-semibold uppercase tracking-wide text-gray-500">Tree Depth</div>
                            <div class="text-xs text-gray-700">
                                <span class="font-semibold" x-text="`Selected D${selectedDepth}`"></span>
                                <span class="text-gray-500" x-text="` / Max D${treeStats.maxDepth}`"></span>
                            </div>
                        </div>
                        <div class="mt-2 h-2 rounded bg-gray-100">
                            <div
                                class="h-2 rounded bg-blue-500 transition-all"
                                :style="`width:${depthPercent}%`"
                            ></div>
                        </div>
                        <div class="mt-3">
                            <div class="mb-1 text-[11px] font-semibold uppercase tracking-wide text-gray-500">Mini Map</div>
                            <div class="max-h-28 space-y-1 overflow-auto pr-1">
                                <template x-for="level in depthLevels" :key="`depth-${level.depth}`">
                                    <button
                                        type="button"
                                        @click="jumpToDepth(level.depth)"
                                        class="flex w-full items-center gap-2 rounded border border-gray-200 px-2 py-1 hover:bg-gray-50"
                                        :class="selectedDepth === level.depth ? 'bg-blue-50 border-blue-200' : 'bg-white'"
                                    >
                                        <span class="w-12 text-left text-xs font-semibold text-gray-700" x-text="`D${level.depth}`"></span>
                                        <div class="h-2 flex-1 rounded bg-gray-100">
                                            <div
                                                class="h-2 rounded bg-indigo-500"
                                                :style="`width:${Math.max(8, (level.count / Math.max(1, treeStats.maxBreadth)) * 100)}%`"
                                            ></div>
                                        </div>
                                        <span class="w-8 text-right text-xs text-gray-600" x-text="level.count"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>

                @if(count($tree['roots']) > 1)
                    <div class="mt-3 rounded-md border border-amber-200 bg-amber-50 p-2 text-xs text-amber-900">
                        Multiple roots detected ({{ count($tree['roots']) }}). Flow may be disconnected.
                    </div>
                @endif

                <div class="mt-3 max-h-[70vh] overflow-auto pr-1" @click="onTreeClick($event)">
                    <template x-for="rootId in visibleRoots()" :key="`root-${rootId}`">
                        <div x-html="renderNode(rootId, 0)"></div>
                    </template>
                </div>
            @endif
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4">
            <div class="text-sm font-semibold text-gray-800">Clone / Reuse Sub-flow</div>
            <div class="mt-1 text-xs text-gray-600">Select a source start node, then attach to target YES/NO/root.</div>

            <div class="mt-3 grid grid-cols-1 gap-2">
                <input
                    type="text"
                    wire:model.live.debounce.250ms="cloneSearch"
                    class="w-full rounded-md border border-gray-300 p-2 text-sm"
                    placeholder="Search in question dropdowns"
                />
                <button
                    type="button"
                    wire:click="useSelectedAsAttachTarget"
                    class="rounded-md border border-blue-300 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100"
                >
                    Use selected node as attach target
                </button>
            </div>

            <div class="mt-4 space-y-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Source Problem</label>
                    <select wire:model.change="sourceProblemId" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                        <option value="">Choose source problem</option>
                        @foreach($allProblems as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Source Start Question</label>
                    <select wire:model.change="sourceQuestionId" class="w-full rounded-md border border-gray-300 p-2 text-sm" @disabled(!$sourceProblemId)>
                        <option value="">Choose source question</option>
                        @foreach($this->filteredSourceQuestions as $q)
                            <option value="{{ $q->id }}">#{{ $q->id }} - {{ \Illuminate\Support\Str::limit($q->question_text, 80) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Attach Mode</label>
                    <select wire:model.change="attachMode" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                        <option value="yes">Attach to YES</option>
                        <option value="no">Attach to NO</option>
                        <option value="root">Set as ROOT (target must be empty)</option>
                    </select>
                </div>

                @if($attachMode !== 'root')
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Attach To (Target Question)</label>
                        <select wire:model.change="targetAttachQuestionId" class="w-full rounded-md border border-gray-300 p-2 text-sm" @disabled(!$selectedProblem)>
                            <option value="">Choose target question (or use selected node)</option>
                            @foreach($this->filteredTargetQuestions as $q)
                                <option value="{{ $q->id }}">#{{ $q->id }} - {{ \Illuminate\Support\Str::limit($q->question_text, 80) }}</option>
                            @endforeach
                        </select>
                        <div class="mt-1 text-xs text-gray-500">If empty, clone uses selected tree node as target automatically.</div>
                    </div>
                @else
                    <div class="rounded-md border border-gray-200 bg-gray-50 p-3 text-xs text-gray-600">
                        ROOT attach works only if target problem has no questions.
                    </div>
                @endif

                <button
                    wire:click="cloneFlow"
                    class="mt-1 w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 disabled:opacity-50"
                    @disabled(!$sourceProblemId || !$sourceQuestionId || !$selectedProblem)
                    type="button"
                >
                    Clone and Attach
                </button>
            </div>
        </div>
    </div>

    <script>
        function treeExplorer(tree, selectedNodeId) {
            return {
                tree,
                selectedNodeId,
                expanded: {},
                search: '',
                compact: true,
                focusSelected: false,
                nodeMeta: {},
                init() {
                    this.buildNodeMeta();
                    if (!this.selectedNodeId && this.tree.roots.length) {
                        this.selectedNodeId = this.tree.roots[0];
                        this.$wire.selectTreeNode(this.selectedNodeId);
                    }
                },
                buildNodeMeta() {
                    const meta = {};
                    const queue = [];

                    (this.tree.roots || []).forEach((rootId) => {
                        queue.push({ id: Number(rootId), depth: 1, from: null });
                    });

                    while (queue.length) {
                        const current = queue.shift();
                        if (!current?.id || !this.tree.nodes[current.id]) continue;

                        if (!meta[current.id] || current.depth < meta[current.id].depth) {
                            meta[current.id] = { depth: current.depth, parent: current.from };
                        } else {
                            continue;
                        }

                        const node = this.tree.nodes[current.id];
                        if (node.yes) queue.push({ id: Number(node.yes), depth: current.depth + 1, from: current.id });
                        if (node.no) queue.push({ id: Number(node.no), depth: current.depth + 1, from: current.id });
                    }

                    this.nodeMeta = meta;
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
                        if (node?.yes || node?.no) {
                            next[node.id] = true;
                        }
                    });
                    this.expanded = next;
                },
                collapseAll() {
                    this.expanded = {};
                },
                selectNode(id) {
                    this.selectedNodeId = id;
                    this.$wire.selectTreeNode(id);
                },
                jumpToDepth(depth) {
                    const target = Object.keys(this.nodeMeta).find((id) => this.nodeMeta[id]?.depth === depth);
                    if (!target) return;
                    this.selectNode(Number(target));
                    this.focusSelected = true;
                },
                onTreeClick(event) {
                    const button = event.target.closest('[data-tree-action]');
                    if (!button) return;

                    const action = button.getAttribute('data-tree-action');
                    const nodeId = Number(button.getAttribute('data-node-id'));

                    if (!nodeId) return;
                    if (action === 'toggle') {
                        this.toggleNode(nodeId);
                    }
                    if (action === 'select') {
                        this.selectNode(nodeId);
                    }
                },
                visibleRoots() {
                    if (this.focusSelected && this.selectedNodeId && this.tree.nodes[this.selectedNodeId]) {
                        return [Number(this.selectedNodeId)];
                    }
                    return this.tree.roots || [];
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

                    if (!this.containsSearchInBranch(id, cache)) {
                        return '';
                    }

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

                    if (!hasChildren || !expanded) {
                        return card;
                    }

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
                    const items = Object.values(this.tree.nodes || {}).filter((node) => {
                        return `${node.id} ${node.text ?? ''}`.toLowerCase().includes(q);
                    });
                    return items.slice(0, 24);
                },
                get selectedDepth() {
                    return this.nodeMeta[this.selectedNodeId]?.depth || 1;
                },
                get treeStats() {
                    const depthCounts = {};
                    Object.values(this.nodeMeta).forEach((item) => {
                        const d = item.depth || 1;
                        depthCounts[d] = (depthCounts[d] || 0) + 1;
                    });
                    const levels = Object.keys(depthCounts).map((x) => Number(x));
                    const maxDepth = levels.length ? Math.max(...levels) : 0;
                    const maxBreadth = levels.length ? Math.max(...levels.map((l) => depthCounts[l])) : 0;
                    return { maxDepth, maxBreadth, depthCounts };
                },
                get depthLevels() {
                    return Object.entries(this.treeStats.depthCounts)
                        .map(([depth, count]) => ({ depth: Number(depth), count }))
                        .sort((a, b) => a.depth - b.depth);
                },
                get depthPercent() {
                    const maxDepth = this.treeStats.maxDepth || 1;
                    return Math.min(100, Math.max(0, (this.selectedDepth / maxDepth) * 100));
                },
            };
        }
    </script>
</div>
