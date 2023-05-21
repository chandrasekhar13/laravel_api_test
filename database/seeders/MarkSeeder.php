<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = ['English', 'Maths', 'Science', 'Social'];
        $test_dates = ['2023-05-15', '2023-05-16', '2023-05-17', '2023-05-18'];
        for ($i = 0; $i < 20; $i++) {

            foreach ($subjects as $key => $subject) {

                DB::table('marks')->insert([
                    'student_id' => $i + 1,
                    'subject_name' => $subject,
                    'marks' => rand(20, 100),
                    'test_date' => $test_dates[$key],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),

                ]);
            }
        }
    }
}
