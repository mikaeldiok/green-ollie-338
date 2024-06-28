<?php

namespace Modules\Cashier\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Cashier\Models\TransactionDetail;
use Modules\Menu\Models\Food;

class TransactionsController extends Controller
{
    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;



    public function __construct()
    {
        // Page Title
        $this->module_title = 'Transactions';

        // module name
        $this->module_name = 'transactions';

        // directory path of the module
        $this->module_path = 'cashier::frontend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Cashier\Models\Transaction";
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
{
    $module_title = $this->module_title;
    $module_name = $this->module_name;
    $module_path = $this->module_path;
    $module_icon = $this->module_icon;
    $module_model = $this->module_model;
    $module_name_singular = Str::singular($module_name);

    $module_action = 'List';

    // Assuming your food model is named Food and located in Modules\Cashier\Models
    $foods = \Modules\Menu\Models\Food::latest()->paginate(12);

    return view(
        "$module_path.$module_name.index",
        compact('module_title', 'module_name', 'foods', 'module_icon', 'module_action', 'module_name_singular')
    );
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $id = decode_id($id);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = $module_model::findOrFail($id);

        return view(
            "$module_path.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular")
        );
    }


    public function store(Request $request)
    {
        \Log::debug($request->all());
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $foods = $request->input('food', []);


        // Calculate grand_total

        $total = $request->input('total_price',0);
        $tax = $request->input('tax', 0); // Default to 0 if not
        $discount = $request->input('discount', 0); // Default to 0 if not set
        //$final_tax = $tax/100 * ($total - $discount);
        //$grand_total = $total - $final_tax - $discount;

        // Add grand_total to the request data
        $data = $request->all();
        $data['grand_total'] = $total;
        $data['total'] = $total;
        $data['tax'] = $tax;
        $data['discount'] = $discount;
        $data['number'] = $request->input('number',0);
        $data['name'] = $request->input('atas_nama',0);
        $data['status'] = "Belum Lunas";
        $data['is_inplace'] = $request->input('in_place',0);
        $data['payment'] = $request->input('payment',0);
        $lastTransaction = $module_model::orderBy('id', 'desc')->first();
        $lastInvoiceNumber = $lastTransaction ? intval(substr($lastTransaction->invoice, 3)) : 0;
        $newInvoiceNumber = str_pad($lastInvoiceNumber + 1, 4, '0', STR_PAD_LEFT);
        $data['invoice'] = 'INV' . $newInvoiceNumber;

        $$module_name_singular = $module_model::create($data);
        $total_temp = 0;


        \Log::debug($foods);

        \Log::debug(is_array($foods));
        if (is_array($foods)) {
            // Loop through each food item
            foreach ($foods as $food) {
                // Perform your operations on each $food item
                // For example, you could save each food item to the database
                // Assuming you have a Food model

                TransactionDetail::create([
                    'transaction_id' =>$transaction->id,
                    'food_id' => $food['id'],
                    'quantity' => $food['quantity'],
                    'total_price' => $food['price']*$food['quantity'],
                ]);;
            }
        }



        flash("New '".Str::singular($module_title)."' Added")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return response()->json(['message' => 'Transaction created successfully', 'Invoice' => $data['invoice']], 200);
    }
}
