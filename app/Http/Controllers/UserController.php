<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::with('roles')->get(),
            'all_columns' => $this->get_all_columns(new UserRequest()),
            'columns' => Auth::user()->component_columns['user'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        try {
            $validated = $request->validated();
            $component_columns = [];
            $component_columns['category'] = (new Controller())->get_all_columns(new CategoryRequest());
            $component_columns['article'] = (new Controller())->get_all_columns(new ArticleRequest());
            $component_columns['user'] = (new Controller())->get_all_columns(new UserRequest());
            $validated['component_columns'] = $component_columns;

            $user = User::create($validated);
            $user->roles()->attach($request->role_id);

            return response()->json([
                'message' => 'Запись сохранена!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Inertia\Response
     */
    public function show(User $user)
    {
        return \Inertia\Inertia::render('Users/Profile', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        if (isset($user->roles[0])) {
            $user['role_id'] = $user->roles[0]->id;
        }
        return Inertia::render('Users/Edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $validated = $request->validated();
            if (isset($validated['component_columns'])) {
                $key = array_key_first($validated['component_columns']);
                $value = $validated['component_columns'][$key];
                $validated['component_columns'] = $user->component_columns;
                $validated['component_columns'][$key] = $value;
            }
            $user->update($validated);
            if ($request->role_id) {
                $user->roles()->sync([$request->role_id]);
            }
            return response()->json([
                'message' => 'Запись изменена!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                'message' => 'Запись удалена!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

}
