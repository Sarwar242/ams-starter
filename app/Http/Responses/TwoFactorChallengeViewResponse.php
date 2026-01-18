<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\TwoFactorChallengeViewResponse as TwoFactorChallengeViewResponseContract;

class TwoFactorChallengeViewResponse implements TwoFactorChallengeViewResponseContract
{
    public function toResponse($request)
    {
        return view('auth.two-factor-challenge');
    }
}
