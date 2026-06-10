<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::withCount('assets');

        // Logic Filter Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $rooms = $query->latest()->paginate(10);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:rooms,code|max:10',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Room::create($request->all());
        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'code' => 'required|max:10|unique:rooms,code,' . $room->id,
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $room->update($request->all());
        return redirect()->route('rooms.index')->with('success', 'Ruangan diperbarui.');
    }

    public function destroy(Room $room)
    {
        if ($room->assets()->count() > 0) {
            return back()->withErrors(['Gagal: Ruangan tidak bisa dihapus karena masih berisi aset.']);
        }

        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}