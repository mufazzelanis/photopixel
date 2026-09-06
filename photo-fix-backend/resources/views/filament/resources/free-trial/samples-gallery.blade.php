@php
    /** @var \Illuminate\Support\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media */
    $media = $media ?? collect();
@endphp

<div class="ftz-gallery">
    @foreach ($media as $item)
        @php
            $full = $item->getUrl();
            $thumb = $item->hasGeneratedConversion('thumb') ? $item->getUrl('thumb') : $full;
            $ext = $item->extension ?: pathinfo($item->file_name, PATHINFO_EXTENSION);
            $downloadName = \Illuminate\Support\Str::slug($item->name ?: 'sample-'.$item->id).($ext ? '.'.$ext : '');
            $size = $item->human_readable_size;
        @endphp

        <figure class="ftz-card">
            <div class="ftz-thumb">
                <img src="{{ $thumb }}" alt="{{ $item->name }}" loading="lazy">

                <div class="ftz-overlay">
                    <a href="{{ $full }}" download="{{ $downloadName }}" title="Download original ({{ strtoupper($ext) }})" class="ftz-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3v12M7 12l5 5 5-5M5 21h14" />
                        </svg>
                    </a>
                    <a href="{{ $full }}" target="_blank" rel="noopener" title="Open full size" class="ftz-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h6v6M10 14 21 3M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5" />
                        </svg>
                    </a>
                </div>

                <span class="ftz-ext">{{ strtoupper($ext) ?: 'FILE' }}</span>
            </div>

            <figcaption class="ftz-meta">
                <span class="ftz-name" title="{{ $item->name }}">{{ $item->name ?: $item->file_name }}</span>
                <span class="ftz-size">{{ $size }}</span>
            </figcaption>
        </figure>
    @endforeach
</div>

<style>
    .ftz-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 0.875rem;
    }
    .ftz-card {
        margin: 0;
        border: 1px solid rgb(228 228 231);
        border-radius: 0.75rem;
        overflow: hidden;
        background: #fff;
        transition: box-shadow .15s ease, transform .15s ease;
    }
    .ftz-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.10); transform: translateY(-2px); }
    .dark .ftz-card { border-color: rgb(63 63 70); background: rgb(24 24 27); }

    .ftz-thumb { position: relative; aspect-ratio: 1 / 1; background: rgb(244 244 245); }
    .dark .ftz-thumb { background: rgb(39 39 42); }
    .ftz-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }

    .ftz-overlay {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center; gap: 0.625rem;
        background: rgba(9, 9, 11, .55);
        opacity: 0; transition: opacity .15s ease;
    }
    .ftz-thumb:hover .ftz-overlay { opacity: 1; }

    .ftz-btn {
        display: grid; place-items: center;
        width: 2.25rem; height: 2.25rem;
        border-radius: 9999px;
        background: #fff; color: rgb(24 24 27);
        box-shadow: 0 2px 8px rgba(0,0,0,.2);
        transition: transform .12s ease, background .12s ease, color .12s ease;
    }
    .ftz-btn:hover { transform: scale(1.08); background: rgb(99 102 241); color: #fff; }

    .ftz-ext {
        position: absolute; left: .5rem; top: .5rem;
        padding: .1rem .4rem;
        font-size: .625rem; font-weight: 700; letter-spacing: .03em;
        border-radius: .375rem;
        background: rgba(9,9,11,.7); color: #fff;
    }

    .ftz-meta {
        display: flex; align-items: center; justify-content: space-between; gap: .5rem;
        padding: .5rem .625rem;
        font-size: .75rem;
    }
    .ftz-name {
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        color: rgb(39 39 42); font-weight: 500;
    }
    .dark .ftz-name { color: rgb(228 228 231); }
    .ftz-size { flex-shrink: 0; color: rgb(113 113 122); }
</style>
