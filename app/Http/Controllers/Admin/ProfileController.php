<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Profile\Actions\UpdateProfile;
use App\Domain\Profile\Models\Profile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::singleton();

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(UpdateProfileRequest $request, UpdateProfile $action)
    {
        $data = $request->validated();

        // Upload avatar
        if ($request->hasFile('avatar')) {
            $profile = Profile::singleton();

            // Supprimer l'ancien avatar
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('profile', 'public');
        }

        $action->execute($data);

        return redirect()->route('admin.profile.edit')
            ->with('success', __('Profil mis à jour.'));
    }
}
