<?php

namespace App\Domain\Profile\Actions;

use App\Domain\Profile\Models\Profile;

class UpdateProfile
{
    public function execute(array $data): Profile
    {
        $profile = Profile::singleton();
        $profile->update($data);

        return $profile->fresh();
    }
}
