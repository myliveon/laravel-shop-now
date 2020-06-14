<?php


namespace App\Http\Controllers;


use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdentityController extends Controller
{
    public function index(Request $request) {

        $base = env('APP_URL').'/uploads/';
        $identitys = Banner::query()
            ->select('order', 'title', 'desc', 'url',
                DB::raw("CONCAT('$base', `image`) AS `image` "))
            ->where('is_hidden', 0)
            ->where('type', 2)
            ->orderBy('order')
            ->get();
        $total = count($identitys);
        $identitys = collect($identitys);
        if (count($identitys) == 0) {
            return response()->json([
                'code' => '0',
                'msg' => '暂无数据',
            ]);
        }
        $data = [
            'list' => $identitys->values(),
            'total' => $total
        ];
        return response()->json([
            'code' => '1',
            'msg' => '成功',
            'data' => $data,
        ]);

    }

}
