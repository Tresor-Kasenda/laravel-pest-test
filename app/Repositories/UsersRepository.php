<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\Api\Users\EditUserRequest;
use App\Http\Requests\Api\Users\StoreUsersRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

final class UsersRepository
{
    public function getUsersLists(): Collection|array
    {
        return User::query()
            ->latest()
            ->get();
    }

    public function storeUsers(StoreUsersRequest $request): Model|Builder
    {
        return User::query()
            ->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
    }

    public function showUser(string $id): Model|Builder|null
    {
        return User::query()
            ->where('id', '=', $id)
            ->first();
    }

    public function update(EditUserRequest $request, string $id): Model|Builder|null
    {
        $user = $this->showUser($id);
        $user->update($request->validated());

        return $user;
    }

    public function delete(string $id): Model|Builder|null
    {
        $user = $this->showUser(id: $id);
        $user->delete();
        return $user;
    }
}
