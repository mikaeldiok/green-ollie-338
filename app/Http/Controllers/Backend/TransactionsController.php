<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TransactionsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Transactions';

        // module name
        $this->module_name = 'transactions';

        // directory path of the module
        $this->module_path = 'backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "App\Models\Transaction";
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

        $$module_name = $module_model::select('id', 'invoice','name' ,'status','grand_total');

        $data = $$module_name;

        $$module_name->addSelect(DB::raw("(SELECT SUM(quantity) FROM transaction_details WHERE transaction_id = $module_name.id) as total_order"));

        // \Log::info()

    // Add order column based on is_inplace
        $$module_name->addSelect(DB::raw("CASE WHEN is_inplace = 1 THEN 'Ditempat' ELSE 'Take away' END as `order`"));


        return DataTables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column_transaction', compact('module_name', 'data'));
            })
            ->editColumn('invoice', '<strong>{{$invoice}}</strong>')
            ->editColumn('name', '<strong>{{$name}}</strong>')
            ->editColumn('status', '<strong>{{$status}}</strong>')
            ->editColumn('grand_total', 'Rp{{number_format($grand_total, 2, ",", ".")}}')
            ->rawColumns(['invoice', 'name','status','grand_total','action'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        // Calculate grand_total
        $total = $request->input('total');
        $tax = $request->input('tax', 0); // Default to 0 if not
        $discount = $request->input('discount', 0); // Default to 0 if not set
        $final_tax = $tax/100 * ($total - $discount);
        $grand_total = $total - $final_tax - $discount;

        // Add grand_total to the request data
        $data = $request->all();
        $data['grand_total'] = $grand_total;

        $$module_name_singular = $module_model::create($data);

        flash("New '".Str::singular($module_title)."' Added")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return redirect("admin/{$module_name}");
    }

    public function payOrder(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $record = $module_model::findOrFail($id);

        $record->update($request->all());

        $record->status = "Lunas";
        $record->save();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$record->id);

        return response()->json([
            'message' => 'Record updated successfully.',
            'record' => $record,
        ]);
    }
}
