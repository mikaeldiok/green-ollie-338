<?php

namespace Modules\Cashier\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class CashiersController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Cashiers';

        // module name
        $this->module_name = 'cashiers';

        // directory path of the module
        $this->module_path = 'cashier::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Cashier\Models\Cashier";
    }

}
