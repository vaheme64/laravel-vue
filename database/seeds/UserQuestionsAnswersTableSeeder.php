<?php

use Illuminate\Database\Seeder;

class UserQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('answers')->delete();
        \DB::table('questions')->delete();
        \DB::table('users')->delete();
        // $this->call(UsersTableSeeder::class);
        factory(App\User::class,3)->create()->each(function ($user){
            $user->questions()
                ->saveMany(
                    factory(App\Question::class,rand(1,5))->make()
                )->each(function($q){
                    $q->answers()->saveMany(factory(App\Answer::class,rand(1,5))->make());
                });
        });
//        factory(App\Question::class,10)->create();
    }
}
