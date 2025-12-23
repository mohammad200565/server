<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\HasRelationsShip;
use App\Http\Traits\NotificationTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseApiController extends Controller
{
    use ApiResponseTrait, AuthorizesRequests, HasRelationsShip, NotificationTrait;
}
