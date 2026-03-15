<?php

namespace App\Http\Controllers\Api;

use App\Domain\Profile\Actions\GetProfile;
use App\Http\Resources\ProfileResource;

class ProfileController
{
    public function show(GetProfile $action): ProfileResource
    {
        return new ProfileResource($action->execute());
    }
}
