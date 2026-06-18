@props(['label' => 'Foto', 'name' => 'images', 'hint' => 'Unggah beberapa foto. Klik bintang untuk menandai cover.'])

<div x-data="{
        images: [],
        cover: 0,
        store: new DataTransfer(),
        add(e) {
            for (const f of e.target.files) {
                if (!f.type.startsWith('image')) continue;
                this.store.items.add(f);
                this.images.push({ url: URL.createObjectURL(f), name: f.name });
            }
            this.$refs.input.files = this.store.files;
        },
        remove(i) {
            this.store.items.remove(i);
            this.$refs.input.files = this.store.files;
            this.images.splice(i, 1);
            if (this.cover >= this.images.length) this.cover = Math.max(0, this.images.length - 1);
        }
    }">
    <div class="mb-1.5 flex items-center justify-between">
        <label class="text-[13px] font-semibold text-navy-800">{{ $label }}</label>
        <span class="text-xs text-slate-500" x-text="images.length + ' foto'"></span>
    </div>
    <p class="mb-3 text-xs text-slate-500">{{ $hint }}</p>

    <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 lg:grid-cols-5">
        <template x-for="(img, i) in images" :key="i">
            <div class="group relative aspect-square overflow-hidden rounded-lg ring-1 ring-line" :class="cover === i && 'ring-2 ring-brass-500'">
                <img :src="img.url" class="h-full w-full object-cover" alt="">
                <div class="absolute inset-0 flex items-start justify-between bg-navy-900/0 p-1.5 transition-colors group-hover:bg-navy-900/30">
                    <button type="button" @click="cover = i" class="grid h-7 w-7 place-items-center rounded-md bg-white/90 text-brass-700 shadow" :class="cover === i ? 'opacity-100' : 'opacity-0 group-hover:opacity-100'" title="Jadikan cover">
                        <svg class="h-4 w-4" :fill="cover === i ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.6 6.3 6.4.5-4.9 4.2 1.5 6.5L12 17.8 6.4 20.5 7.9 14 3 9.8l6.4-.5L12 3Z"/></svg>
                    </button>
                    <button type="button" @click="remove(i)" class="grid h-7 w-7 place-items-center rounded-md bg-white/90 text-danger opacity-0 shadow transition-opacity group-hover:opacity-100" title="Hapus">
                        <x-admin.icon name="trash" class="h-4 w-4" />
                    </button>
                </div>
                <span x-show="cover === i" class="absolute bottom-1 left-1 rounded bg-brass-500 px-1.5 py-0.5 text-[9px] font-bold uppercase text-navy-900">Cover</span>
            </div>
        </template>

        <label class="flex aspect-square cursor-pointer flex-col items-center justify-center gap-1 rounded-lg border border-dashed border-slate-300 bg-paper2/40 text-slate-500 transition-colors hover:border-brass-500 hover:text-brass-700">
            <x-admin.icon name="plus" class="h-5 w-5" />
            <span class="text-[11px] font-semibold">Tambah</span>
            <input x-ref="input" type="file" name="{{ $name }}[]" accept="image/*" multiple class="hidden" @change="add">
        </label>
    </div>
    <input type="hidden" name="cover_index" :value="cover">
</div>
