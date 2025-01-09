<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'invoice';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>


    <div class="row">
        <div class="col-12 mb-3">
            <div class="form-group">
                <?php
                $field_name = 'number';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
                ?>
                {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            </div>
        </div>
    </div>


    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'status';
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select an option --";
            $required = "required";
            $select_options = [
                '1'=>'Lunas',
                '0'=>'Belum Lunas',
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
        </div>
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'is_inplace';
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select an option --";
            $required = "required";
            $select_options = [
                '1'=>'Ditempat',
                '0'=>'Take Away',
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
        </div>
    </div>



    <div class="row">
        <div class="col-12 mb-3">
            <div class="form-group">
                <?php
                $field_name = 'grand_total';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
                ?>
                {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            <div class="form-group">
                <?php
                $field_name = 'tax';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
                ?>
                {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
                {{ html()->text($field_name,10)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            <div class="form-group">
                <?php
                $field_name = 'total';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
                ?>
                {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            </div>
        </div>
    </div>

{{--
    <div class="row">
        <div class="col-12 mb-3">
            <div class="form-group">
                <?php
                $field_name = 'discount';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
                ?>
                {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            </div>
        </div>
    </div> --}}


    <div class="row">
        <div class="col-12 mb-3">
            <div class="form-group">
                <?php
                $field_name = 'payment';
                $field_lable = label_case($field_name);
                $field_placeholder = $field_lable;
                $required = "";
                ?>
                {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            </div>
        </div>
    </div>




</div>


<x-library.select2 />
