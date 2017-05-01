<?php

namespace TypiCMS\Modules\Files\Models;

use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Presenters\ModulePresenter;
use TypiCMS\Modules\Galleries\Models\Gallery;
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

    protected $appends = ['thumb_src', 'thumb_sm', 'alt_attribute_translated'];

    /**
     * Get back office’s edit url of model.
     *
     * @return string|void
     */
    public function editUrl()
    {
        $parameters = [$this->id];
        if (request('redirect_to_gallery')) {
            $parameters['redirect_to_gallery'] = request('redirect_to_gallery');
        }
        try {
            return route(
                'admin::edit-'.str_singular($this->getTable()),
                $parameters
            );
        } catch (InvalidArgumentException $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Get back office’s index of models url.
     *
     * @return string|void
     */
    public function indexUrl()
    {
        try {
            if (request('redirect_to_gallery')) {
                return route('admin::edit-gallery', [$this->gallery_id, 'tab' => 'tab-files']);
            }

            return route('admin::index-'.$this->getTable());
        } catch (InvalidArgumentException $e) {
            Log::error($e->getMessage());
        }
    }

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
        return $this->belongsTo(File::class, 'folder_id', 'id');
    }

    /**
     * One folder has many children files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(File::class, 'folder_id', 'id');
    }

    /**
     * Append thumb_src attribute from presenter.
     *
     * @return string
     */
    public function getThumbSrcAttribute()
    {
        return $this->present()->thumbSrc(null, 22, [], 'name');
    }

    /**
     * Append thumb_sm attribute from presenter.
     *
     * @return string
     */
    public function getThumbSmAttribute()
    {
        return $this->present()->thumbSrc(240, 240, ['resize'], 'name');
    }
}
