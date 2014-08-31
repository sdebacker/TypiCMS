<?php
if (! function_exists('activeClass')) {
    /**
     * return 'active' if this is the current page
     *
     * @return string 'active' or ''
     */
    function activeClass($uri)
    {
        return Request::is($uri) ? 'active' : '';
    }
}

if (! function_exists('getIdFromSlug')) {
    /**
     * I have slug, give me id.
     *
     * @param  string  $module
     * @param  string  $slug
     * @return integer
     */
    function getIdFromSlug($module = null, $slug = null)
    {
        if (! $module or ! $slug) {
            return false;
        }

        $moduleSingular = str_singular($module);
        $translationsTable = $moduleSingular . '_translations';

        return DB::table($module)
                ->join($translationsTable, $module . '.id', '=', $translationsTable . '.' . $moduleSingular . '_id')
                ->where('slug', $slug)
                ->where('locale', App::getLocale())
                ->pluck($module . '.id');
    }
}

if (! function_exists('getSlugsFromId')) {
    /**
     * I have id, give me slugs.
     *
     * @param  string $module
     * @param  int    $id
     * @return Array
     */
    function getSlugsFromId($module = null, $id = null)
    {
        if (! $module or ! $id) {
            return false;
        }

        $moduleSingular = str_singular($module);
        $translationsTable = $moduleSingular . '_translations';

        return DB::table($module)
                ->join($translationsTable, $module . '.id', '=', $translationsTable . '.' . $moduleSingular . '_id')
                ->where($module . '.id', $id)
                ->where($translationsTable . '.status', 1)
                ->lists('slug', 'locale');
    }
}

if (! function_exists('array_indent')) {
    /**
     * Indent values of an array with spaces. One with keys and the other with values.
     *
     * @return array  $array['title' = string, 'id' => int]
     */
    function array_indent($array)
    {
        $parent = 0;
        $items = [];
        foreach ($array as $item) {
            $indent = '';
            if ($item->parent) {
                $indent = '&nbsp;&nbsp;&nbsp;&nbsp;';
                if ($parent and $parent < $item->parent) {
                    $indent .= $indent;
                }
            }
            $parent = $item->parent;
            $items[$indent . $item->title] = $item->id;
        }
        return $items;
    }
}
