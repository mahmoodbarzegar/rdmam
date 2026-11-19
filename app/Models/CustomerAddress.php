<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable=[
        'customer_id',
        'addressDetail',
        'erp_addressId',
        'fax',
        'name',
        'phone',
        'regionalDivisionName',
        'regionalDivisionRef',
    ];
}
