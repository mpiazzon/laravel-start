<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
		$this->command->info('grupo admin y usuario admin@admin.com/admin creados!');
	}
}

class UserTableSeeder extends Seeder {

  public function run()
  {

  	// Create the group
    $group = Sentry::createGroup(array(
        'name'        => 'Admin',
        'permissions' => array(
            'admin' => 1,
            'users' => 1,
        ),
    ));
    
    // Create the user
    $user = Sentry::createUser(array(
        'email'     => 'admin@admin.com',
        'password'  => 'admin',
        'activated' => true,
    ));

    // Find the group using the group id
    $adminGroup = Sentry::findGroupById(1);

    // Assign the group to the user
    $user->addGroup($adminGroup);

  }

}
