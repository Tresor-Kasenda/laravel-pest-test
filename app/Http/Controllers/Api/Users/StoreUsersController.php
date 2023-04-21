<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use App\Action\Users\SendUserEmailPipeline;
use App\Action\Users\StoreUsersPipeline;
use App\Http\Requests\Api\Users\StoreUsersRequest;
use App\Http\Resources\Api\Users\ListUsersResources;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Pipeline;
use Symfony\Component\HttpFoundation\Response;

final class StoreUsersController
{
    public function __invoke(StoreUsersRequest $request): JsonResponse
    {
        $user = Pipeline::through($request)
            ->through([
                StoreUsersPipeline::class,
                SendUserEmailPipeline::class,
            ])
            ->send($request)
            ->thenReturn();

        return response()->json(
            data: ListUsersResources::make($user),
            status: Response::HTTP_OK
        );
    }
}
