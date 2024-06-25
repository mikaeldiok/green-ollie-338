<?php

namespace Modules\Menu\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class FoodsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Foods';

        // module name
        $this->module_name = 'foods';

        // directory path of the module
        $this->module_path = 'menu::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-pizza';

        // module model name, path
        $this->module_model = "Modules\Menu\Models\Food";
    }

    public function index_data() : JsonResponse
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        $$module_name = $module_model::select('id', 'name','image','price', 'updated_at');

        $data = $$module_name;

        return DataTables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column', compact('module_name', 'data'));
            })
            ->editColumn('image', function($data){

                return '<figure class="figure">
                            <a target="_blank" href="'.$data.'" data-lightbox="image-set" data-title="Path: '.asset($data->image).'">
                                <img src="'.$data->image.'" class="figure-img img-fluid rounded img-thumbnail" style="max-width: 100px; max-height: 100px;" alt="">
                            </a>
                        </figure>';
            })
            ->editColumn('name', '<strong>{{$name}}</strong>')
            ->editColumn('price', 'Rp{{number_format($price, 2, ",", ".")}}')

            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                }

                return $data->updated_at->isoFormat('llll');
            })
            ->rawColumns(['name', 'image','action'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }
}
