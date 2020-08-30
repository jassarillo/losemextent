<?php

if(! function_exists('menuActive')) {
    function menuActive( $url )
    {
        return ( Request::is($url) )? 'active open' : '';
    }
}

if(! function_exists('arrowOpen')) {
    function arrowOpen( $url )
    {
        return ( Request::is($url) )? 'open' : '';
    }
}
