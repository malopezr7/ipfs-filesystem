<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * App\DocumentElements
 *
 * @property int $id
 * @property string $elementable_type
 * @property int $elementable_id
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Model|Eloquent $elementable
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereElementableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereElementableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $element_type
 * @property int $element_id
 * @property int $order
 * @property-read Model|Eloquent $element
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereElementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereElementType($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|DocumentElement[] $children
 * @property-read int|null $children_count
 * @property-read DocumentElement|null $parent
 * @method static \Illuminate\Database\Query\Builder|DocumentElement onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|DocumentElement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DocumentElement withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentElement whereOrder($value)
 */


class DocumentElement extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'element_type',
        'element_id',
        'parent_id',
    ];



    public function full_url()
    {
        $folders = new Collection();
        $folder = $this;
        while ($folder != null) {
            $folders->push($folder);
            $folder = $folder->parent;
        }
        $url = '';
        foreach ($folders->reverse() as $key => $item){
            $slash = $key > 0 ? '/' : '';
            $url .= $item->element->name . $slash;
        }
        return $url;
    }


    public function element(){
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->with('children')
            ->orderBy('created_at','asc');
    }


    public function nextNumberToOrderParam(){
        // Es un grupo raíz perteneciente a una ruta concreta, por lo que devuelvo el order+1 siguiente
        return $this->children()->count() + 1;
    }
}
