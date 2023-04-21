<?php

declare(strict_types=1);

namespace App\Action\Users;

use App\Http\Requests\Api\Users\StoreUsersRequest;
use App\Repositories\UsersRepository;

final class StoreUsersPipeline
{
    public function __construct(protected readonly UsersRepository $repository)
    {
    }

    public function handle(StoreUsersRequest $request, $next)
    {
        $this
            ->repository
            ->storeUsers(request: $request);
        return $next($request);
    }
}
