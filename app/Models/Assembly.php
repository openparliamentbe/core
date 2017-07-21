<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent model to manage assemblies.
 *
 * An assembly is a legislative chamber in a parliament, or a parliament
 * itself (in the case of a unicameral parliament). Examples include the
 * ‘Chamber of Representatives’ or the ‘Brussels Regional Parliament’.
 */
class Assembly extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * The table uses single-letter constants as primary keys.
     * As a result, it does not use auto-incrementing since
     * it would be impossible to apply to strings anyway.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * Since this table only consists of simple, read-only
     * data, we are not interested in keeping creation and
     * modification timestamps for it.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_en',
        'name_fr',
        'name_nl',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name_en' => 'string',
        'name_fr' => 'string',
        'name_nl' => 'string',
    ];
}
