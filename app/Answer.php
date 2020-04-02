<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Answer extends Model
{
    protected $fillable=['body','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute()
    {
//        return \Parsedown::instance()->text($this->body);
        return $this->body." ";
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($answer){
            $answer->question->increment('answer_count');
        });

        static::deleted(function ($answer){
//            $question=$answer->question;
//            $question->decrement('answer_count');
//            if($question->best_answer_id===$answer->id){
//                $question->best_answer_id=null;
//                $question->save();
//            }
            $answer->question->decrement('answer_count');
        });
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function isBest()
    {
        return $this->id===$this->question->best_answer_id;
    }

    public function votes()
    {
        return $this->morphToMany(User::class,'votable');
    }
}
