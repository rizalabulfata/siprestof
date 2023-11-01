<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    const PENDING = 'pending';
    const APPROVE = 'approve';
    const REJECT = 'reject';
}
