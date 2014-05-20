<?php
if (Request::segment(1) != 'admin') {

    Route::bind('categories', function ($value, $route) {
        return TypiCMS\Modules\Categories\Models\Category::select('categories.id AS id', 'slug', 'status')
            ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('slug', $value)
            ->where('status', 1)
            ->firstOrFail();
    });

}
