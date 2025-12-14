<?php

if (! function_exists('tenant_route')) {
    function tenant_route($name, $params = []) {

        if (! is_array($params)) {
            $params = ['id' => $params];
        }

        if (app()->has('library')) {
            $params['library'] = app('library')->slug;
            return route($name, $params);
        }

        return '#';
    }
}
