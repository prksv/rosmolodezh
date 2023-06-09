<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Services\AverageMark\AverageMarkExercise;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Services\AcademicPerformance\AcademicPerformanceExercise;

class Exercise extends Model
{
    use HasFactory, SoftDeletes,  Filterable, CascadeSoftDeletes, Sluggable;

    protected $cascadeDeletes = ['answers'];
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'body',
        'user_id',
        'block_id',
        'complexity_id',
        'active',
        'time',
    ];

    protected $appends = [
//        'complexityClassName',
//        'complexityTimeClassName',
//        'name_minute_count',
//        'answers_added_count',
//        'academic_performance_percent',
//        'average_score',
//        'mark_count'
    ];
    protected $with = [
        'answers'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getComplexityClassNameAttribute()
    {

        return Complexity::where('id', $this->complexity_id)
            ->first()
            ->class_name;
    }
    public function getComplexityTimeClassNameAttribute()
    {
        $time = ComplexityTime::where('started_at','<=', $this->time)
        ->where('ended_at','>=', $this->time)
        ->first();

        return ComplexityTime::where('started_at','<=', $this->time)
                ->where('ended_at','>=', $this->time)
                ->first()
                ? ComplexityTime::where('started_at','<=', $this->time)
                    ->where('ended_at','>=', $this->time)
                    ->first()->class_name
                : 'dark';

    }

    public function getNameMinuteCountAttribute()
    {

        $finished = $this->time % 10;
        $last = 'минут';

        if ($finished === 1 ) {
            $last = 'минута';
        }
        if ($finished === 2 || $finished === 3 || $finished === 4) {
            $last = 'минуты';
        }
        if($this->time == 11 ||$this->time == 12 ||$this->time == 13 ||$this->time == 14 ) {
            $last = 'минут';
        }

        return $last;
    }

    public function getAnswersAddedCountAttribute()
    {
        return Answer::where('exercise_id', $this->id)->get()->count();
    }
    public function getMarkCountAttribute()
    {
        return Answer::where('exercise_id', $this->id)->whereNotNull('mark')->get()->count();
    }

    public function getAcademicPerformancePercentAttribute()
    {
        [ "performance" => $performance ] = AcademicPerformanceExercise::getPerformance($this, $this->studentsCount);
        return $performance * 100 . "%";
    }

    public function getAverageScoreAttribute(): int
    {
        ['result'=> $result ] = AverageMarkExercise::getMark($this);
        return $result;
    }
    /**
     *  Relation with users (one to many)
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }
    /**
     *  Relation with users (one to many)
     * @return HasMany
     */
    public function users(): hasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relation with users (many to many)
     *
     * @return BelongsToMany
     */
    public function getStudentsCountAttribute()
    {
        return $this->block->track->users_count;
    }

    /**
     * Get the complexity that owns the Exercise
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function complexity(): BelongsTo
    {
        return $this->belongsTo(Complexity::class);
    }

    /**
     *  Relation with blocks (one to many)
     * @return BelongsTo
     */
    public function block(): belongsTo
    {
        return $this->belongsTo(Block::class);
    }


    /**
     *  Relation with answers (one to many)
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return Track
     */
    public function track(): Track
    {
        return $this->block->track;
    }

    /**
     *  Relation with videos (one to many)
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Relation with links (one to many)
     * @return HasMany
     */
    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    /**
     * Relation with files (one to many)
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }


}
