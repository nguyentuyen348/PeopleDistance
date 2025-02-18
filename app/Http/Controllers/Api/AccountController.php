<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Models\Account;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 25;
        $data = Account::select([
            '*'
        ])->paginate($per_page);

        Log::info('User truy cập trang index account');
        return response()->json($data, 200);
    }

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

    public function store(AccountStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data_request = $request->all();
            $data = Account::create($data_request);
            DB::commit();
            Log::info('Tạo mới account: ' . $request->login);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $data = [
                "status" => "failed",
                "messages" => $e->getmessage(),
            ];
            Log::error('Lỗi tạo account: ' . $e->getMessage());
            return response()->json($data, 200);
        }
    }

    public function show($id)
    {
        $data = Account::find($id);
        if (!$data) {
            $data = [
                'status' => 'failed',
                'messages' => 'Data không tồn tại',
            ];
            return response()->json($data, 200);
        }
        return response()->json($data, 200);
    }

    public function update($id, AccountUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = Account::find($id);

            if (empty($data)) {
                $data = [
                    'status' => 'failed',
                    'messages' => 'not found'
                ];
                return response()->json($data, 200);
            }

            $data_request = $request->all();
            $data->update($data_request);
            DB::commit();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $data = [
                'status' => 'failed',
                'messages' => $e->getmessage(),
            ];
            Log::error('Lỗi sửa account: ' . $e->getMessage());
            return response()->json($data);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = Account::find($id);
            if (empty($data)) {
                $data = [
                    'status' => 'failed',
                    'messages' => 'Data không tồn tại'
                ];
                return response()->json($data, 200);
            }
            $data->delete();
            DB::commit();
            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $data = [
                'status' => 'failed',
                'messages' => $e->getmessage(),
            ];
            Log::error('Lỗi xóa account: ' . $e->getMessage());
            return response()->json($data, 200);
        }
    }
}
