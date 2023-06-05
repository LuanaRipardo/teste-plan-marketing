<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

    /**
     * @OA\Info(
     *     version="2.0.1",
     *     title="Datasys API",
     *     description="Documentação da API implementada",
     *     @OA\Contact(
     *         email="luana.ripardo96@outlook.com"
     *     )
     * )
     * 
     * @OA\SecurityScheme(
     *    securityScheme="bearer",
     *    type="http",
     *    scheme="bearer"
     * )
     */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

}
