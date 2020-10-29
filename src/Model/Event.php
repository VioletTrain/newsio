<?php

namespace Newsio\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;
use JsonSerializable;

/**
 * Newsio\Model\Event
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Database\Eloquent\Collection|\Newsio\Model\Tag[] $tags
 * @property \Illuminate\Database\Eloquent\Collection|\Newsio\Model\Link[] $links
 * @property int $category_id
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Newsio\Model\Category|null $category
 * @property-read int|null $links_count
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Query\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Event withoutTrashed()
 */
class Event extends BaseModel implements JsonSerializable
{
    use SoftDeletes;

    protected $table = 'events';
    private string $reason = '';

    protected $fillable = [
        'title', 'category_id'
    ];

    protected $visible = [
        'id', 'title', 'tags', 'links', 'reason', 'category_id', 'updated_at'
    ];

    /**
     * @param string $reason
     * @return Event
     * @throws Exception
     */
    public function remove(string $reason): Event
    {
        $this->reason = $reason;
        $this->delete();

        return $this;
    }

    /** Relations */

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'events_tags', 'event_id', 'tag_id');
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class, 'event_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id');
    }

    public function jsonSerialize()
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'tags'     => $this->tags->pluck('name'),
            'links'    => $this->links->pluck('content'),
            'category' => $this->category
        ];
    }
}
