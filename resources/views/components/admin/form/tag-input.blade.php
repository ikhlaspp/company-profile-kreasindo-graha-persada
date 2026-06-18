@props(['label' => 'Tag', 'name' => 'tags', 'tags' => []])

<div x-data="{
        tags: @js(array_values((array) $tags)),
        draft: '',
        add() { const t = this.draft.trim(); if (t && !this.tags.includes(t)) this.tags.push(t); this.draft = ''; },
        remove(i) { this.tags.splice(i, 1); }
    }">
    @if ($label)<label class="mb-1.5 block text-[13px] font-semibold text-navy-800">{{ $label }}</label>@endif
    <div class="flex flex-wrap items-center gap-1.5 rounded-lg border border-line bg-card p-2 transition-colors focus-within:border-brass-500 focus-within:ring-2 focus-within:ring-brass-500/20">
        <template x-for="(tag, i) in tags" :key="i">
            <span class="inline-flex items-center gap-1 rounded-md bg-navy-100 py-1 pl-2 pr-1 text-xs font-semibold text-navy-700">
                <span x-text="tag"></span>
                <button type="button" @click="remove(i)" class="grid h-4 w-4 place-items-center rounded text-navy-600 hover:bg-navy-600/20">✕</button>
                <input type="hidden" name="{{ $name }}[]" :value="tag">
            </span>
        </template>
        <input type="text" x-model="draft" @keydown.enter.prevent="add()" @keydown.comma.prevent="add()" @blur="add()"
               placeholder="Ketik lalu Enter…" class="min-w-[8rem] flex-1 border-0 bg-transparent p-1 text-sm text-navy-900 placeholder:text-slate-500 focus:ring-0">
    </div>
    <p class="mt-1 text-xs text-slate-500">Pisahkan dengan Enter atau koma.</p>
</div>
