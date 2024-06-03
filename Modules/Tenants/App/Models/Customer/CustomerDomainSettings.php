<?php
/*
 * ${PROJECT_NAME} | CustomerDomainSettings.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 15:49
*/
namespace Modules\Tenants\App\Models\Customer;

use Database\Factories\CustomerDomainSettingsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDomainSettings extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'customer_domain_settings';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['customer_id', 'customer_domains_id','countries','keywords','links'];

    protected $casts = [
      'countries' => 'json',
      'keywords' => 'json',
      'links' => 'json',
    ];
    public static function newFactory()
    {
        return CustomerDomainSettingsFactory::new();
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerDomain()
    {
        return $this->belongsTo(CustomerDomain::class, 'customer_domains_id');
    }
}
