<?php

namespace App\Http\Controllers;

use App\Models\Instagram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstagramController extends Controller
{
    /* =========================================================
       PUBLIC — settings + posts in one response
    ========================================================= */
    public function index()
    {
        $settings = Instagram::settings()->first();
        $posts = Instagram::posts()->orderBy('id')->get();

        return response()->json([
            'instagram' => [
                'handle'      => $settings?->handle ?? '',
                'profile_url' => $settings?->profile_url ?? '',
                'posts'       => $posts,
            ],
        ]);
    }

    /* =========================================================
       ADMIN — update channel settings (singleton row)
    ========================================================= */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'handle'      => 'required|string|max:100',
            'profile_url' => 'required|string|max:500|url',
        ]);

        $settings = Instagram::settings()->firstOrNew(['type' => 'settings']);

        $settings->fill([
            'handle'      => $validated['handle'],
            'profile_url' => $validated['profile_url'],
        ]);

        $settings->save();

        return response()->json([
            'message'   => 'Instagram settings updated successfully.',
            'instagram' => $settings->fresh(),
        ]);
    }

    /* =========================================================
       ADMIN — single post
    ========================================================= */
    public function show(Instagram $post)
    {
        if ($post->type !== 'post') {
            abort(404);
        }

        return response()->json(['post' => $post]);
    }

    /* =========================================================
       ADMIN — create post
       Either url OR image — not both, not neither.
       For URL: user copies Instagram share link, pastes here.
    ========================================================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'url'   => 'nullable|required_without:image|string|max:500|url',
            'image' => 'nullable|required_without:url|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = [
            'type'  => 'post',
            'url'   => null,
            'image' => null,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('instagram', 'public');
        } else {
            $data['url'] = $validated['url'];
        }

        $post = Instagram::create($data);

        return response()->json([
            'message' => 'Instagram post created successfully.',
            'post'    => $post,
        ], 201);
    }

    /* =========================================================
       ADMIN — update post
    ========================================================= */
    public function update(Request $request, Instagram $post)
    {
        if ($post->type !== 'post') {
            abort(404);
        }

        $validated = $request->validate([
            'url'   => 'nullable|required_without:image|string|max:500|url',
            'image' => 'nullable|required_without:url|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // new image → delete old, set new
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $post->image = $request
                ->file('image')
                ->store('instagram', 'public');
            $post->url = null;
        } elseif (!empty($validated['url'])) {
            // switching to URL → delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
                $post->image = null;
            }

            $post->url = $validated['url'];
        }
        // else: no changes → keep existing

        $post->save();

        return response()->json([
            'message' => 'Instagram post updated successfully.',
            'post'    => $post->fresh(),
        ]);
    }

    /* =========================================================
       ADMIN — delete post
    ========================================================= */
    public function destroy(Instagram $post)
    {
        if ($post->type !== 'post') {
            abort(404);
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'message' => 'Instagram post deleted successfully.',
        ]);
    }
}
