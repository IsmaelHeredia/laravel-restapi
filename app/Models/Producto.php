<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = "productos";
    protected $fillable = ["nombre", "descripcion", "precio","proveedor_id"];

	public function proveedor()
    {
        return $this->belongsTo("App\Proveedor");
    }
}
