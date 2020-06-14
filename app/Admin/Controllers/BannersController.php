<?php

namespace App\Admin\Controllers;

use App\Models\Banner;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BannersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '轮播图';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner);

//        $grid->column('id', __('Id'));
        $grid->column('type', __('图片类型'))->using(['1' => '轮播图', '2' => '标示图']);
        $grid->column('order', __('排序'));
        $grid->column('title', __('标题'));
        $grid->column('desc', __('描述'));
        $grid->column('url', __('连接'));
        $grid->is_hidden('状态')->display(function ($value) {
            return $value ? '暂停' : '启用';
        });
        $grid->created_at('创建时间');
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Banner);
        $type = [
            1 => '轮播图',
            2 => '标示图',
        ];

        $form->number('order', __('排序'));
        $form->text('title', __('标题'));
        $form->image('image', '图片')->uniqueName()->rules('required|image');
        $form->text('desc', __('描述'));
        $form->url('url', __('Url'));
        $form->radio('is_hidden', '是否隐藏')->options(['1' => '是', '0' => '否']);
        $form->radio('type','图片类型')->options($type)->default('1')->required(true);

        return $form;
    }



}
