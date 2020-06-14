<?php

namespace App\Http\Controllers;

use App\Models\CrowdfundingProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    // 秒杀
    public function getSkillProducts(Request $request) {

    }

    // 众筹
    public function getCrowdFundingProducts(Request $request) {
        $base = env('APP_URL').'/uploads/';
        $page = request('page', 1);
//        \Illuminate\Support\Facades\Log::info('ProductsController page = '.$a);
        $pageSize = request('pagesize', 20);

        $status = request('type', CrowdfundingProduct::STATUS_FUNDING);

        $crowdFunding =  DB::table('products')
            ->join('crowdfunding_products', 'products.id', '=', 'crowdfunding_products.product_id')
            ->select('products.id', 'type', 'title', 'long_title', 'description','on_sale', 'price', 'sold_count',
                DB::raw("CONCAT('$base', `image`) AS `image` "), 'target_amount',
                'total_amount', 'user_count', 'end_at', 'status', "STR_TO_DATE(`end_at`,'%Y-%m-%d')")
            ->where('on_sale', true)
            ->where('type', Product::TYPE_CROWDFUNDING)
            ->where('status', $status)
            ->get();
        $total = count($crowdFunding);
        $crowdFunding = collect($crowdFunding)->forPage($page, $pageSize);
        if (count($crowdFunding) == 0) {
            return response()->json([
                'code' => '1',
                'msg' => '暂无数据',
            ]);
        }
        $data = [
            'list' => $crowdFunding->values(),
            'total' => $total
        ];
        return response()->json([
            'code' => '1',
            'msg' => '成功',
            'data' => $data,
        ]);
    }


    public function index(Request $request, $type = 'normal')
    {

        // 创建一个查询构造器
//        $builder = Product::query()->where('on_sale', true);
//
//        $products = $builder->where('type', $type)->paginate(10);
//        $base = env('APP_URL').'/uploads/';
        $page = request('page', 1);
//        \Illuminate\Support\Facades\Log::info('ProductsController page = '.$a);
        $pageSize = request('pagesize', 20);
        $goods =  DB::table('products')
            ->select('id', 'type', 'title', 'long_title', 'description', 'image', 'on_sale', 'price', 'sold_count')
            ->where('on_sale', true)
            ->where('type', $type)
            ->get();
        $total = count($goods);
        $goods = collect($goods)->forPage($page, $pageSize);
        if (count($goods) == 0) {
            return response()->json([
                'code' => '0',
                'msg' => '暂无数据',
            ]);
        }
        $data = [
            'list' => $goods->values(),
            'total' => $total
        ];
        return response()->json([
            'code' => '1',
            'msg' => '成功',
            'data' => $data,
        ]);

    }



}
