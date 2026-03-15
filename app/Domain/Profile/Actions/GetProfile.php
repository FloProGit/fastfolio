<?php

namespace App\Domain\Profile\Actions;

use App\Domain\Profile\Models\Profile;

class GetProfile
{
    public function execute(): Profile
    {
        return Profile::singleton();
    }
}
