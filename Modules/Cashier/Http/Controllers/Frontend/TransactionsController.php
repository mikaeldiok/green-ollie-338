<?php

namespace Modules\Cashier\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
    
        $module_action = 'Store';
    
        $foods = $request->input('arrayfood', []);
        

        // Calculate grand_total
        $total = $request->input('total',0);
        $tax = $request->input('tax', 0); // Default to 0 if not 
        $discount = $request->input('discount', 0); // Default to 0 if not set
        //$final_tax = $tax/100 * ($total - $discount);
        //$grand_total = $total - $final_tax - $discount;
    
        // Add grand_total to the request data
        $data = $request->all();
        $data['grand_total'] = $total;
    
        $$module_name_singular = $module_model::create($data);
        $total_temp = 0;


        if (is_array($foods)) {
            // Loop through each food item
            foreach ($foods as $food) {
                // Perform your operations on each $food item
                // For example, you could save each food item to the database
                // Assuming you have a Food model

                

                $total_temp = $total_temp + $food['total_price'];
                TransactionDetail::create([
                    'transaction_id' =>$transactions->id,
                    'food_id' => $food['food_id'],
                    'quanity' => $food['quantity'],
                    'total_price' => $food['total_price'],
                    // other fields...
                ]);;
            }
        }

        
        $tax = $request->input('tax', 0); // Default to 0 if not 
        $discount = $request->input('discount', 0); // Default to 0 if not set
        $transactions->grand_total = $tax/100 *  ($total_temp- $discount);
        $transactions->save();
        
    
        flash("New '".Str::singular($module_title)."' Added")->success()->important();
    
        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);
    
        return redirect("admin/{$module_name}");
    }
}
