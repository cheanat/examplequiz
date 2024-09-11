<?php

namespace App\Models\Api;

use App\Models\Cart;
use App\Models\User;
use App\Models\Api\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'image_url'
    ];
     public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function getAllQuiz(){
        return $this->hasMany(Quiz::class,'category_id','id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'cart')->withTimestamps();
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }




}
