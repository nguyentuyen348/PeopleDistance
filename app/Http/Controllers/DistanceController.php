<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistanceController extends Controller
{

    public function calculateDistance($p1, $p2)
    {
        return sqrt(pow($p1[0] - $p2[0], 2) + pow($p1[1] - $p2[1], 2));
    }

    public function findFurthestPeople()
    {

        // Giả định người đi bộ trên các trục (tọa độ x, y)
        $people = [
            [0, 1], [0, 2], [0, 3], [0, 4], [0, 5],
            [-1, 0], [-2, 0], [-3, 0], [-4, 0], [-5, 0],
            [1, 0], [2, 0], [3, 0], [4, 0], [5, 0],
            [0, -1], [0, -2], [0, -3], [0, -4], [0, -5]
        ];
        $distances = [];
        $numPeople = count($people);

        // Tính khoảng cách trung bình của mỗi người với tất cả người khác
        foreach ($people as $i => $person) {
            $totalDistance = 0;
            for ($j = 0; $j < $numPeople; $j++) {
                if ($i !== $j) {
                    $totalDistance += $this->calculateDistance($person, $people[$j]);
                }
            }
            $averageDistance = $totalDistance / ($numPeople - 1);
            $distances[] = ['index' => $i, 'distance' => $averageDistance];
        }

        // Sắp xếp theo khoảng cách giảm dần
        usort($distances, function ($a, $b) {
            return $b['distance'] <=> $a['distance'];
        });

        // Chọn 10% số người xa nhất
        $top10Percent = ceil($numPeople * 0.1);
        $furthestPeople = array_slice($distances, 0, $top10Percent);

        // Trả về danh sách người có khoảng cách xa nhất
        return array_map(function ($entry) use ($people) {
            return $people[$entry['index']];
        }, $furthestPeople);

    }
}
