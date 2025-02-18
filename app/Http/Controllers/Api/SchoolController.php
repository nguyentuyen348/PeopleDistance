<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function get_old()
    {
        $averageAge = 20.67; // 20 tuổi 8 tháng
        $threshold = 0.5; // 6 tháng = 0.5 tuổi

        $students = DB::table('students')
            ->select('class', 'birth_day', DB::raw("
            CASE
                WHEN DATEDIFF(CURRENT_DATE,birth_day)/365 > ($averageAge + $threshold) THEN 'above'
                WHEN DATEDIFF(CURRENT_DATE,birth_day)/365 < ($averageAge - $threshold) THEN 'below'
                ELSE 'equal'
            END as age_group
        "))
            ->get();

        $result = [];

        foreach ($students as $student) {
            $class = $student->class;
            $group = $student->age_group;

            if (!isset($result[$class])) {
                $result[$class] = ['above' => 0, 'below' => 0];
            }

            if ($group === 'above') {
                $result[$class]['above']++;
            } elseif ($group === 'below') {
                $result[$class]['below']++;
            }
        }

        return $result;

    }






}
