<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $table="evaluaciones";

    public function getTituloResumido(){
        return 'E. '.explode(' ', $this->titulo)[1];
    }
}
