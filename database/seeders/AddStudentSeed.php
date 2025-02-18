<?php

namespace Database\Seeders;


use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AddStudentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function get_class($p1,$p2)
    {

        $students = [];
        $faker = Faker::create();
        $classes5 = [];

        for ($j = 0; $j < $p1; $j++) {
            $classes5[] = 'C5'.$j;
        }
        foreach ($classes5 as $class) {
            for ($i = 0; $i < $p2; $i++) { // Mỗi lớp có 35 học sinh
                $students[] = [
                    'name' => $faker->name,
                    'class' => $class,
                    'birth_day' => Carbon::create('2025-02-18')->addDays(-rand(8000, 14000))->toDateString(),
                ];
            }
        }

        return $students;

    }


    public function run()
    {

        $c5 = 5;
        $c5_total = 35;
        $c6 = 6;
        $c6_total = 45;
        $c10 = 10;
        $c10_total = 30;
        $c4 = 4;
        $c4_total = 40;

        $a1 = $this->get_class($c5,$c5_total);
        $a2 = $this->get_class($c6,$c6_total);
        $a3 = $this->get_class($c10,$c10_total);
        $a4 = $this->get_class($c4,$c4_total);

        $result = array_merge($a1,$a2,$a3,$a4);

        foreach ($result as $st){
            Student::updateOrCreate(['name'=>$st['name']],$st);
        }

    }
}
