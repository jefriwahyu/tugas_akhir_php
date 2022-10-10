<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_biodata extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_biodata';
    protected $fillable = ['nama', 'no_hp', 'alamat', 'hobi', 'foto'];
}
