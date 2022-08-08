<?php

namespace App\Models;

use File;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    const ENTITY_DEFAULT = 'default';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'entity',
        'path',
        'title',
        'description',
        'active',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i:s',
        'updated_at' => 'datetime:d.m.Y H:i:s',
    ];

    /**
     * разрешенные форматы файлов для загрузки
     *
     * @var array
     */
    public static $allowMimeTypes = [
        // images
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'svg' => 'image/svg+xml',
        'tiff' => 'image/tiff',
        'wbmp' => 'image/vnd.wap.wbmp',
        'webp' => 'image/webp',
        'ico' => 'image/x-icon',
        // documents
        // 'doc' => 'application/msword',
        // 'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        // 'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
        // 'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        // 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        // 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        // 'pdf' => 'application/pdf',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * Transform image path
     *
     * @param $value [image name]
     * @return string
     */
    // public function getPathAttribute($value): string
    // {
    //     if (!file_exists(strtok($value, '?'))) {
    //         return asset('img/default-image.jpg');
    //     }
    //     return asset($value);
    // }

    /**
     * Get the owning media model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function media()
    {
        return $this->morphTo();
    }

    /**
     * Delete media object
     *
     * @param array $param [{id}]
     * @return int [count]
     */
    public function deleteMedia(array $param) :int
    {
        $ids = is_array($param['id']) ? $param['id'] : [$param['id']];
        $collection = self::whereIn('id', $ids);
        $fileDeleted = 0;
        $items = $collection->get();
        foreach ($items as $media) {
            // https://stackoverflow.com/questions/65732076/getoriginal-is-not-working-in-laravel-8
            if (file_exists($media->getRawOriginal('path'))) {
                File::delete($media->getRawOriginal('path')) && ++$fileDeleted;
            }
        }
        $collection->delete();
        return $fileDeleted;
    }
}
