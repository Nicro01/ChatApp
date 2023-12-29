<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Models\RoomUserPivot;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            //'photo' => $input['photo'],
            'password' => Hash::make($input['password']),
        ]);



        return RoomUserPivot::create([
            'user_id' => User::where('email', $input['email'])->first()->id,
            'room_id' => 1,
        ]);;
    }

    public function savePhoto($photo)
    {
        $name = $photo->getClientOriginalName();
        $photo->move(public_path() . '/images/', $name);
        return $name;
    }
}
