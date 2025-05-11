<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ToastMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // If the response is a view response and there's a toast message in the session
        if ($response instanceof \Illuminate\Http\Response && $request->session()->has('toast')) {
            $toast = $request->session()->get('toast');
            
            // Add the JavaScript to trigger the toast
            $content = $response->getContent();
            $scriptToAdd = "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (window.showToast) {
                        window.showToast('{$toast['message']}', '{$toast['type']}')
                    }
                });
            </script>";
            
            // Insert the script right before the closing body tag
            $content = str_replace('</body>', $scriptToAdd . '</body>', $content);
            $response->setContent($content);
        }
        
        return $response;
    }
}