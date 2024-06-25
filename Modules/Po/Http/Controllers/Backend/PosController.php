<?php

namespace Modules\Po\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class PosController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Pos';

        // module name
        $this->module_name = 'pos';

        // directory path of the module
        $this->module_path = 'po::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Po\Models\Po";
    }

}
