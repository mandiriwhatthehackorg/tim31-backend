<?php

use Illuminate\Database\Seeder;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $dreams = [
            "Trip to Japan 2020",
            "Buy Motor Bike",
            "Buy New Phone",
            "Going Umrah",
            "Arisan Gang Damai"
        ];

        $amounts = [
            32000000,
            18000000,
            5000000,
            40000000,
            3000000,
        ];

        $transactions = [
            100000,
            200000,
            300000,
            400000,
            500000,
            600000,
            700000,
            800000,
            900000,
            110000,
            120000,
            130000,
            140000,
            150000,
            160000,
            170000,
            180000,
            190000,
            200000,
            210000,
            220000,
            230000,
            240000,
            250000,
            260000,
            270000
        ];

        for($i=1; $i<=25; $i++) {
            App\User::create([
                "name" => $faker->name,
            ]);

            App\Account::create([
               "number" => str_random(),
               "balance" => 10000000,
               "user_id" => $i
            ]);

            if($i % 5 == 0) {
                App\Group::create([
                    "name" => $dreams[$i%4],
                    "user_id" => $i,
                    "target_amount" => $amounts[$i%4],
                    "target_date" =>  $i . " Oktober 2020",
                ]);
            }
        }

        $j = 1;
        $k = 1;

        for($i=1; $i<=25; $i++, $k++) {
            App\Session::create([
                "name" => "Session " . $k,
                "group_id" => $j,
            ]);

            if($i % 5 == 0) {
                $j++;
                $k = 0;
            }
        }

        $j = 1;

        for($i=1; $i<=25; $i++) {
            App\UserGroup::create([
                "user_id" => $i,
                "group_id" => $j,
            ]);

            if($i % 5 == 0) {
                $j++;
            }
        }

        $j = 1;

        for($i=1; $i<=25; $i++) {
            $isOut = $i % 2;
            App\Transaction::create([
                "user_id" => $j,
                "amount" => $transactions[$i],
                "isOut" =>  $isOut,
                "session_id" => $i,
            ]);

            if($i % 5 == 0) {
                $j++;
            }
        }
    }
}
