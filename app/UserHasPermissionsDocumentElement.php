<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * App\StorageFile
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_document_element
 * @property bool $can_read
 * @property bool $can_write
 * @property bool $can_delete
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\UserHasPermissionsDocumentElement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement whereIdFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement whereIdTypeFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement whereIdUserUploaded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement whereParentFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserHasPermissionsDocumentElement whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserHasPermissionsDocumentElement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\UserHasPermissionsDocumentElement withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DocumentElement $element
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User $user
 */
class UserHasPermissionsDocumentElement extends BaseModel
{
    protected $table = 'user_has_permissions_element';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'id_user' => 'int',
        'id_file' => 'int',
    ];

    protected $fillable = [
        'id_user',
        'id_document_element',
        'can_read',
        'can_write',
        'can_update',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function element()
    {
        return $this->belongsTo(DocumentElement::class, 'id_document_element');
    }
}