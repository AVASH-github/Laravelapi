<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // If your table name is not the plural form of the model name, specify it explicitly
    protected $table = 'categories'; // This line is optional if the table name is 'categories'
    
    protected $fillable = ['name', 'status']; // Specify the fillable fields
}
