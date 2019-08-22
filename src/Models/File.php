<?php

namespace TypiCMS\Modules\Files\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Presenters\ModulePresenter;
use TypiCMS\Modules\History\Traits\Historable;

class File extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    protected $presenter = ModulePresenter::class;

    protected $guarded = ['id', 'exit'];

    public $translatable = [
        'description',
        'alt_attribute',
    ];

    protected $appends = ['thumb_sm', 'alt_attribute_translated'];

    /**
     * Append title_translated attribute.
     *
     * @return string
     */
    public function getAltAttributeTranslatedAttribute()
    {
        $locale = config('app.locale');

        return $this->translate('alt_attribute', config('typicms.content_locale', $locale));
    }

    /**
     * One file belongs to one folder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder()
    {
        return $this->belongsTo(self::class, 'folder_id', 'id');
    }

    /**
     * One folder has many children files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'folder_id', 'id');
    }

    /**
     * Append thumb_sm attribute from presenter.
     *
     * @return string
     */
    public function getThumbSmAttribute()
    {
        return $this->present()->image(240, 240, ['resize']);
    }
}
