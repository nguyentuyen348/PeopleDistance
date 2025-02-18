<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeopleController extends Controller
{

    public function findTop20PercentByAgeDifference()
    {
        $ages = [25, 30, 35, 50, 60, 22, 18, 70, 65, 40, 30, 28];
        $differences = [];

        foreach ($ages as $i => $age1) {
            foreach ($ages as $j => $age2) {
                if ($i !== $j) {
                    $differences[] = abs($age1 - $age2);
                }
            }
        }
        rsort($differences);

        $topPercentCount = ceil(count($ages) * 0.2);
        $topDifferences = array_slice($differences, 0, $topPercentCount);

        print_r($topDifferences);
    }


}
