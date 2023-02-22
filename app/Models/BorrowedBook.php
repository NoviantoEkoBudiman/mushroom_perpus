<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BorrowedBook extends Model
{
    use HasFactory;
    protected $table = 'borrowed_book';
    protected $fillable = [
        'book_id',
        'murid_id',
        'staff_id'
    ];
}
