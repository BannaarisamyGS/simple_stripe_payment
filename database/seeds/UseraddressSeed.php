<?php

use Illuminate\Database\Seeder;
use App\UserAddresses;

class UseraddressSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(UserAddresses::class,10)->create();
    }
}
