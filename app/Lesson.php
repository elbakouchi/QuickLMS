<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Lesson extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'lessons';

    protected $appends = [
        'joined_files',
        'featured_photo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'slug',
        'title',
        'price',
        'status',
        'content',
        'course_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'free_course',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);

    }

    public function getJoinedFilesAttribute()
    {
        return $this->getMedia('joined_files');

    }

    public function getFeaturedPhotoAttribute()
    {
        $file = $this->getMedia('featured_photo')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;

    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');

    }

}
