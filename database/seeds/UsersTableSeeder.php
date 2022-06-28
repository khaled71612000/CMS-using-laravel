<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get () gives result so just one first 
        //  find where email is equal to this 
        // if not create one
        $user = User::where('email','kspades666@gmail.com')->first();
        // if not found
        if(!$user){
            User::create([
                'name' => 'KKing',
                'email' => 'kspades666@gmail.com',
                'role' => 'admin',
                'password'=> Hash::make('password')
            ]);
        }
    }
}
