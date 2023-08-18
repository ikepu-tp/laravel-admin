<?php

namespace ikepu_tp\LaravelAdmin\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_grant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        "id" => "integer",
        "user_id" => "integer",
        "grant" => "integer",
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id", "created_at", "updated_at", "deleted_at"];

    public function user()
    {
        return $this->belongsTo(config("laravelAdmin.users", ""), "user_id");
    }
}
