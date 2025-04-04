<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\User\Services\UserService;
use Illuminate\Http\Request;
use App\Modules\User\Requests\UserRequest;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
  protected $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function index()
  {
    $users = $this->userService->getAllUsers();
    return view('users.index', compact('users'));
  }

  public function create()
  {
    return view('users.create');
  }

  public function store(UserRequest $request)
  {
    $this->userService->createUser($request->validated());
    return redirect()->route('users.index')->with('success', 'User created successfully');
  }

  public function edit(User $user)
  {
    return view('users.edit', compact('user'));
  }

  public function update(UserRequest $request, User $user)
  {
    $this->userService->updateUser($user, $request->validated());
    return redirect()->route('users.index')->with('success', 'User updated successfully');
  }

  public function destroy(User $user)
  {

    $this->userService->deleteUser($user);
    return redirect()->route('users.index')->with('success', 'User deleted successfully');
  }

  public function updateProfile(UserRequest $request)
  {
    $this->userService->updateProfile(auth()->user(), $request->validated());
    return back()->with('success', 'Profile updated successfully!');
  }
}
