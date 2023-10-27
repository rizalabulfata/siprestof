<?php

namespace App\Helpers;

use Illuminate\Database\Schema\Blueprint as SchemaBlueprint;

class Blueprint extends SchemaBlueprint
{
    /**
     * Add a default table column.
     *
     * @return \Illuminate\Support\Fluent
     */
    public function commonFields()
    {
        $this->timestampTz('created_at')->nullable();
        $this->timestampTz('updated_at')->nullable();
        $this->timestampTz('deleted_at')->nullable();
    }
}
