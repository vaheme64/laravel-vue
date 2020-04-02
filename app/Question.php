<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
   protected $fillable=['title','body'];
    public function user()
    {
//        return $this->belongsTo('App\User');
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title']=$value;
        $this->attributes['slug']=Str::slug($value);
    }

    public function getUrlAttribute()
    {
//        baraye dorost kardan in url ,
//        1: inja url ra dorost kardim
//        2:route ra dar web.php dorost kardim
//        3:dar routeserviceprovider dar function boot , bind kardim ke agar meghdary be name slug amad , dar jadval
//        begardad va meghdar ra be questionsController bedahad
//        4: va akhar questioncontroller neshan bedahad
        return route('questions.show',$this->slug);
//        return '#';
    }

//    public function getTitleAttribute()
//    {
//
//    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
//        return $this->created_at->format('d/m/Y');
    }

    public function getStatusAttribute()
    {
        if($this->answer_count >0){
            if($this->best_answer_id){
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id=$answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class,'favorites')->withTimestamps();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id',auth()->id())->count()>0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function votes()
    {
        return $this->morphToMany(User::class,'votable');
    }
}
