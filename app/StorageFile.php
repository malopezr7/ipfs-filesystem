<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * App\StorageFile
 *
 * @property integer $id
 * @property string $name
 * @property string $hash
 * @property string $url
 * @property integer $id_folder
 * @property integer $id_user_uploaded
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $full_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\UserHasPermissionsFolder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereIdFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereIdTypeFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereIdUserUploaded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereParentFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserHasPermissionsFolder withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\UserHasPermissionsFolder withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\StorageFolder|null $folder
 * @property-read mixed $folder_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereIdNextcloud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsFolder whereToken($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DocumentElement[] $element
 * @property-read int|null $element_count
 */
class StorageFile extends BaseModel
{
    protected $table = 'files';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'id_folder' => 'int',
        'id_user_uploaded' => 'int',
    ];

    protected $fillable = [
        'name',
        'url',
        'content_type',
        'hash',
        'id_folder',
        'id_user_uploaded',
    ];

    protected $appends = [
        'fullUrl',
        'folderName',
    ];

    public function full_url()
    {
        /** @var StorageFolder $folder */
        $folder = StorageFolder::find($this->id_folder);
        if ($folder != null) {
            return $folder->full_url() . '/' . $this->name;
        } else {
            return null;
        }


    }

    public function full_folder_url()
    {
        /** @var StorageFolder $folder */
        $folder = StorageFolder::find($this->id_folder);
        if ($folder != null) {
            return $folder->full_url() . '/';
        } else {
            return null;
        }


    }

    public function getFullUrlAttribute()
    {
        return $this->url . '/' . $this->name;
    }

    public function getFolderNameAttribute()
    {
        return $this->folder->name;
    }


    public function folder()
    {
        return $this->belongsTo(StorageFolder::class, 'id_folder');
    }


    static function getExtension($extension)
    {
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
            case 'png':
                return 'fa fa-file-photo-o';
            case 'mp4' :
                return 'fa fa-file-video-o';
            case 'mp3':
                return 'fa fa-file-audio-o';

            case 'pdf':
                return 'fa fa-file-pdf-o';
            case 'docx':
            case 'pages':
            case 'odt':
            case 'rtf':
            case 'csv':
            case 'tsv':
            case 'doc':
                return 'fa fa-file-text-o';
            case 'xlsx':
            case 'xls':
                return 'fa fa-file-excel-o';
            case 'pptx':
            case 'ppt':
                return 'fa fa-file-powerpoint-o';
            default:
                return 'fa fa-file-o';


        }


    }

    static function getTypeFile($extension)
    {

        switch ($extension) {

            case 'png':
                return '1';
            case 'jpeg':
                return '2';
            case 'jpg':
                return '2';
            case 'mp4' :
                return '3';
            case 'mp3':
                return '8';
            case 'pdf':
                return '5';
            case 'doc':
                return '6';
            case 'docx':
                return '6';
            case 'pages':
                return '9';
            case 'odt':
                return '9';
            case 'rtf':
                return '9';
            case 'xls':
                return '4';
            case 'xlsx':
                return '4';
            case 'csv':
                return '7';
            case 'tsv':
                return '7';
            case 'ppt':
                return '7';
            case 'pptx':
                return '7';
            default:

                return null;


        }


    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_user_uploaded');
    }

    public function typeFile(){
        return $this->belongsTo('App\TypeFile','id_type_file');
    }

    public function file_extension(){
        return explode('.',$this->name)[1];
    }

    public function element(){
        return $this->morphMany(DocumentElement::class, 'element');
    }
}