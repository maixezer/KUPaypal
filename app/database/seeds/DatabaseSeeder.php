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
	}

}

class UserTableSeeder extends Seeder {
	public function run()
	{
		DB::table('users')->delete();

		$dob = new DateTime('2014-01-01');

		User::create(
			array(
				'first_name' => 'test',
				'last_name' => 'test',
				'date_of_birth' => $dob->format('Y-m-d'),
				'phone' => '123123123',
				'address' => '111/2321'
			)
		);
	}
}
