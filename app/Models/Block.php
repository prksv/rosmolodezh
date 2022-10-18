<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $table = 'blocks';
    protected $cascadeDeletes = ['exercises'];

    protected $fillable = [
        'title',
        'body',
        'image',
        'track_id',
        'user_id',
        'date_start',
        'priority',
    ];

    protected $withCount = [
        'exercises'
    ];
    protected $with = [
        'exercises'
    ];
    protected $appends = [
        'image_original',
        'image_medium',
        'image_thumbnail',
        'image_small',
        'image_big'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'date_end',
        'date_start',
        'deleted_at'
    ];


    public function getNextBlockUrlAttribute()
    {
        $block = Block::where('track_id', $this->track_id)
                    ->where('priority', $this->priority + 1)
                    ->first();
        if ($block) {
            return route('tracks.blocks.show',[$block->track_id,$block->id]);
        }
        return false;
    }


    public function getBeforeBlockUrlAttribute()
    {
        $block = Block::where('track_id', $this->track_id)
                    ->where('priority', $this->priority - 1)
                    ->first();
        if ($block) {
            return route('tracks.blocks.show',[$block->track_id,$block->id]);
        }
        return false;
    }

    public function getDurationAttribute()
    {
        $exercises = Exercise::where('block_id', $this->id)->without(['creator', 'users', 'complexity', 'block', 'answers'])->get();
//        $exercises = $this->exercises;
        $time = 0;



        foreach ($exercises as $exercise) {
            $time += $exercise->time;
        }
        return round($time / 60);
    }

    public function getNameDurationAttribute()
    {
        $duration = $this->duration % 10;

        if ($duration === 2 || $duration === 3 || $duration === 4) {
            return 'часа';
        } elseif ($duration === 1 && $this->duration !== 11) {
            return 'час';
        } else {
            return 'часов';
        }
    }


    public function getAverageScoreAttribute()
    {
        $score = 0;
        $exercises = Exercise::where('block_id', $this->id)->without(['creator', 'users', 'complexity', 'block', 'answers'])->get();
//        $exercises = $this->exercises;
        $i = 0;

        foreach ($exercises as $exercise) {
            $answers = Answer::where('exercise_id', $exercise->id)->without(['exercise', 'user'])->get();
//            $answers = $exercise->answers;
            foreach ($answers as $answer) {
                if ($answer->mark) {
                    $score += $answer->mark;
                    $i++;
                }
            }
        }
        if ($i === 0) {
            return 0;
        }
        return round($score / $i, 1);
    }

    public function getNameExercisesCountAttribute()
    {
        if ($this->exercises_count === 1) {
            return 'упражнение';
        } elseif ($this->exercises_count === 2 || $this->exercises_count === 3 || $this->exercises_count === 4) {
            return 'упражнения';
        } else {
            return 'упражнений';
        }
    }

    public function getImageOriginalAttribute()
    {
        return asset('storage/blocks/images/originals/' . $this->image);
    }

    public function getImageNormalAttribute()
    {
        return asset('storage/blocks/images/normal/normal_' . $this->image);
    }

    public function getImageThumbnailAttribute()
    {
        return asset('storage/blocks/images/thumbnail/thumbnail_' . $this->image);
    }

    public function getImageMediumAttribute()
    {
        return asset('storage/blocks/images/medium/medium_' . $this->image);
    }

    public function getImageSmallAttribute()
    {
        return asset('storage/blocks/images/small/small_' . $this->image);
    }

    public function getImageBigAttribute()
    {
        return asset('storage/blocks/images/big/big_' . $this->image);
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
     *  Relation with users (one to many)
     *
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     *  Relation with tracks (one to many)
     * @return BelongsTo
     */
    public function track(): belongsTo
    {
        return $this->belongsTo(Track::class)->withTrashed();
    }

    /**
     *  Relation with exercises (one to many)
     * @return HasMany
     */
    public function exercises(): hasMany
    {
        return $this->hasMany(Exercise::class);
    }

    /**
     *  Relation with exercises (one to many)
     * @return HasMany
     */
    public function deleted_exercises(): hasMany
    {
        return $this->hasMany(Exercise::class)->onlyTrashed();
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

    public function started_blocks()
    {
        return $this->belongsToMany(User::class);
    }

}
