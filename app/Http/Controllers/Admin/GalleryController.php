<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date')->get();
        $galleryPhotos = GalleryPhoto::with('event')->latest()->paginate(12);

        return view('admin.documentation.index', compact('events', 'galleryPhotos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['photo_path'] = $request->file('photo')->store('documentation', 'public');
        unset($validated['photo']);

        $galleryPhoto = GalleryPhoto::create($validated);
        ActivityLog::record('create_gallery_photo', 'Foto dokumentasi ditambahkan untuk event ' . ($galleryPhoto->event?->title ?? 'tanpa event'));

        return back()->with('success', 'Foto dokumentasi berhasil ditambahkan.');
    }

    public function edit(GalleryPhoto $galleryPhoto)
    {
        $events = Event::orderBy('date')->get();

        return view('admin.documentation.edit', compact('galleryPhoto', 'events'));
    }

    public function update(Request $request, GalleryPhoto $galleryPhoto)
    {
        $validated = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($request->hasFile('photo')) {
            if ($galleryPhoto->photo_path) {
                Storage::disk('public')->delete($galleryPhoto->photo_path);
            }

            $validated['photo_path'] = $request->file('photo')->store('documentation', 'public');
        }

        unset($validated['photo']);
        $galleryPhoto->update($validated);

        ActivityLog::record('update_gallery_photo', 'Foto dokumentasi diperbarui');

        return redirect()->route('admin.dokumentasi.index')->with('success', 'Foto dokumentasi berhasil diperbarui.');
    }

    public function destroy(GalleryPhoto $galleryPhoto)
    {
        if ($galleryPhoto->photo_path) {
            Storage::disk('public')->delete($galleryPhoto->photo_path);
        }

        $galleryPhoto->delete();
        ActivityLog::record('delete_gallery_photo', 'Foto dokumentasi dihapus');

        return back()->with('success', 'Foto dokumentasi berhasil dihapus.');
    }
}