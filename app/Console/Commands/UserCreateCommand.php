<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user['name'] = $this->ask('Name ');
        $user['email'] = $this->ask('Email ');
        $user['password'] = $this->secret('Password');

        $roleName = $this->choice('Role of the new User', ['admin', 'editor',], default: 1);

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error('Role not found');
            return -1;
        }
        $validator = Validator::make($user, [
            'name' => ['required', 'string', 'max:225'],
            'email' => ['required', 'string', 'email', 'unique:'.User::class],
            'password' => ['required', Password::defaults()],

        ]);
        if ($validator->fails()){
            foreach ($validator->errors()->all() as  $error){
                $this->error($error);
            }
            return -1;
        }
        DB::transaction(function () use ($user, $role) {
            $user['password'] = Hash::make($user['password']);
            $newUser = User::create($user);
            $newUser->roles()->attach($role->id);
        });

        $this->info('User' . $user['email'] . 'Created Successfully');

        return 0;
    }
}
