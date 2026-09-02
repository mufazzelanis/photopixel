<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Support\Media;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::query()->published()->with('category')->paginate(9);

        return response()->json([
            'data' => collect($posts->items())->map(fn (BlogPost $p) => $this->card($p)),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'total' => $posts->total(),
            ],
        ]);
    }

    public function show(BlogPost $post)
    {
        abort_unless($post->is_published, 404);
        $post->increment('views');
        $post->load('category');

        return response()->json(['data' => [
            ...$this->card($post),
            'body' => $post->body,
            'cover' => Media::url($post, 'cover', 'web'),
            'seo' => [
                'title' => $post->seo_title ?: $post->title,
                'description' => $post->seo_description ?: $post->excerpt,
            ],
        ]]);
    }

    private function card(BlogPost $p): array
    {
        return [
            'title' => $p->title,
            'slug' => $p->slug,
            'excerpt' => $p->excerpt,
            'category' => $p->category?->name,
            'author_name' => $p->author_name,
            'read_time' => $p->read_time,
            'published_at' => $p->published_at?->toIso8601String(),
            'cover' => Media::url($p, 'cover', 'thumb'),
        ];
    }
}
