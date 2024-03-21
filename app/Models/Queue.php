<?php
/**
 * File Name: Queue
 * Author: pruna
 * Created: 6/7/2023
 *
 * License:
 * --------------
 * SC WEBDIRECT TEHNOLOGIES SRL
 *
 * Change Log:
 * --------------
 * Date         | Author         | Description
 * 6/7/2023 | pruna | Initial version
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
