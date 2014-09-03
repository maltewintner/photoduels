<?php

class UserSeeder extends Seeder {

    public function run()
    {
        DB::table('user')->truncate();
        DB::table('password_reminder')->truncate();

        /*
        User::create(array(
            'email' => null,
            'password' => Hash::make(''),
            'username' => null,
        ));
        */
    }

}