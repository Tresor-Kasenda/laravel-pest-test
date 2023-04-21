<?php

declare(strict_types=1);

namespace App\Action\Users;

use App\Http\Requests\Api\Users\StoreUsersRequest;
use App\Mail\Api\Users\StoreUserEmail;
use Illuminate\Support\Facades\Mail;

final class SendUserEmailPipeline
{
    public function handle(StoreUsersRequest $request, $next)
    {
        Mail::to($request->input('email'))
            ->send(new StoreUserEmail(user: $request->user()));
        return $next($request);
    }
}
