<?php

namespace Yab\Quarx\Repositories;

use Illuminate\Support\Facades\Schema;
use Yab\Quarx\Models\Widget;

class WidgetRepository
{
    /**
     * Returns all Widgets.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Widget::orderBy('created_at', 'desc')->all();
    }

    public function paginated()
    {
        return Widget::orderBy('created_at', 'desc')->paginate(25);
    }

    public function search($input)
    {
        $query = Widget::orderBy('created_at', 'desc');
        $query->where('id', 'LIKE', '%'.$input['term'].'%');

        $columns = Schema::getColumnListing('widgets');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input['term'].'%');
        }

        return [$query, $input['term'], $query->paginate(25)->render()];
    }

    /**
     * Stores Widgets into database.
     *
     * @param array $input
     *
     * @return Widgets
     */
    public function store($input)
    {
        return Widget::create($input);
    }

    /**
     * Find Widgets by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Widgets
     */
    public function findWidgetsById($id)
    {
        return Widget::find($id);
    }

    /**
     * Find Widgets by given slug.
     *
     * @param int $slug
     *
     * @return \Illuminate\Support\Collection|null|static|Widgets
     */
    public static function getWidgetBySLUG($slug)
    {
        return Widget::where('slug', $slug)->first();
    }

    /**
     * Updates Widgets into database.
     *
     * @param Widgets $widgets
     * @param array   $input
     *
     * @return Widgets
     */
    public function update($widgets, $input)
    {
        return $widgets->update($input);
    }
}
