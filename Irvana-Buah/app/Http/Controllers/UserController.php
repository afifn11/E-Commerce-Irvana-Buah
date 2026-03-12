<?php

namespace App\Http\Controllers\Admin;

use App\DTO\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {}

    public function index(): View
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $userData = UserDTO::fromStoreRequest($request);
        $this->userService->createUser($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $userData = UserDTO::fromUpdateRequest($request);
        $this->userService->updateUser($user, $userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->userService->deleteUser($user);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
