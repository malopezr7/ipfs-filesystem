<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * App\FolderFile
 *
 * @property integer $id
 * @property string $name
 * @property string $hash
 * @property integer $id_folder
 * @property integer $id_user_uploaded
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StorageFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StorageFolder newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\StorageFolder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StorageFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StorageFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StorageFolder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StorageFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StorageFolder whereIdFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StorageFolder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\StorageFolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\StorageFolder withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\StorageFolder withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DocumentElement[] $element
 * @property-read int|null $element_count
 */
class StorageFolder extends BaseModel
{
    protected $table = 'folders_files';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'id_folder' => 'int',
    ];

    protected $fillable = [
        'name',
        'hash',
        'id_folder',
        'id_user_uploaded',
    ];

    public function full_url()
    {
        $folders = new Collection();
        $folder = $this;
        while ($folder != null) {
            $folders->push($folder);
            $folder = StorageFolder::find($folder->id_folder);
        }
        $url = '';
        $folders->map(function ($folder, $key) use ($url){
            $url .= $folder . $key > 0 ? '/' : '';
        });
        return $url;
    }

    public function element()
    {
        return $this->morphMany(DocumentElement::class,'element');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_user_uploaded');
    }

}
