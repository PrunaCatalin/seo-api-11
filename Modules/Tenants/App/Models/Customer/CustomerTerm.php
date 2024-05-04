<?php
/*
 * ${PROJECT_NAME} | CustomerTerm.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 03.05.2024 15:38
*/

namespace Modules\Tenants\App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerTerm extends Model
{
    protected $table = 'customer_terms';  // Ensure the model uses the correct table

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'type',
        'checked',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'checked' => 'boolean',
    ];

    /**
     * Get the customer that owns the terms.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
