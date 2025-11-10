<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'page' => 'nullable|integer|min:1',
            'sortBy' => 'nullable|string|in:name,email,created_at',
        ]);

        $users = User::query()
            ->select('id', 'email', 'name', 'role', 'created_at')
            ->withCount('orders')
            ->where('active', true)
            ->when($validated['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy(
                $validated['sortBy'] ?? 'created_at',
                in_array($validated['sortBy'] ?? null, ['name', 'email']) ? 'asc' : 'desc'
            )
            ->simplePaginate(10);

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'name' => 'required|string|min:3|max:50',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            "id" => $user->id,
            "email" => $user->email,
            "name" => $user->name,
            "created_at" => $user->created_at,
        ]);
    }
}
