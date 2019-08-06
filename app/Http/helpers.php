<?php

if(!function_exists('admin_url')) {
    function admin_url($url = '') {
        return url('admin/' . $url);
    }
}

if(!function_exists('admin')) {
    function admin() {
        return auth()->guard('admin');
    }
}

if(!function_exists('lang')) {
    function lang() {
        return session()->has('lang') ? session('lang') : 'en';
    }
}

if(!function_exists('direction')) {
    function direction() {
        if(session()->has('lang')) {
            if(session('lang') == 'ar') {
                return 'rtl';
            }
        }
        return 'ltr';
    }
}

if(!function_exists('datatable_lang')) {
    function datatable_lang() {
        return [
            'sProcessing'       => trans('admin.sProcessing'),
            'sLengthMenu'       => trans('admin.sLengthMenu'),
            'sZeroRecords'      => trans('admin.sZeroRecords'),
            'sEmptyTable'       => trans('admin.sEmptyTable'),
            'sInfo'             => trans('admin.sInfo'),
            'sInfoEmpty'        => trans('admin.sInfoEmpty'),
            'sInfoFiltered'     => trans('admin.sInfoFiltered'),
            'sInfoPostFix'      => trans('admin.sInfoPostFix'),
            'sSearch'           => trans('admin.sSearch'),
            'sUrl'              => trans('admin.sUrl'),
            'sInfoThousands'    => trans('admin.sInfoThousands'),
            'sLoadingRecords'   => trans('admin.sLoadingRecords'),
            'oPaginate'         => [
                'sFirst'        => trans('admin.sFirst'),
                'sLast'         => trans('admin.sLast'),
                'sNext'         => trans('admin.sNext'),
                'sPrevious'     => trans('admin.sPrevious'),
            ],
            'oAria'             => [
               'sSortAscending' => trans('admin.sSortAscending'),
               'sSortDescending'=> trans('admin.sSortDescending'),
            ],
        ];
    }
}
