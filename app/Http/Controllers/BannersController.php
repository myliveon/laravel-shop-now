<?php


namespace App\Http\Controllers;


use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannersController extends Controller
{
    public function index(Request $request) {

        $base = env('APP_URL').'/uploads/';
        $banners = Banner::query()
            ->select('order', 'title', 'desc', 'url',
                DB::raw("CONCAT('$base', `image`) AS `image` "))
            ->where('is_hidden', 0)
            ->where('type', 1)
            ->orderBy('order')
            ->get();
        $total = count($banners);
        $banners = collect($banners);
        if (count($banners) == 0) {
            return response()->json([
                'code' => '0',
                'msg' => '暂无数据',
            ]);
        }
        $data = [
            'list' => $banners->values(),
            'total' => $total
        ];
        return response()->json([
            'code' => '1',
            'msg' => '成功',
            'data' => $data,
        ]);

    }


}
