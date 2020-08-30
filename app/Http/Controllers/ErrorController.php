<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function error(Request $request)
    {
$error = $request->error;
        switch ($request->error) {
            case $request->error == 401:
            abort($error);
                break;
            case $request->error == 403:
            abort($error);
                break;
            case $request->error == 404:
            abort($error);
            case $request->error == 500:
            abort($error);
                break;
            default:
            abort(404);
        }
    }
}
