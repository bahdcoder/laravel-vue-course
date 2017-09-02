<?php 

namespace Bahdcasts\Exceptions;

use Exception;

class AuthFailedException extends Exception 
{
    public function render() {
        return response()->json([
            'message' => 'These credentials do not match our records.'
        ], 422);
    }
}