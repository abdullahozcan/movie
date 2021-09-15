<?php

namespace Juzaweb\Movie\Http\Controllers\Frontend;

use Juzaweb\Models\Taxonomy;
use Juzaweb\Movie\Models\Movie\Movie;
use Juzaweb\Http\Controllers\FrontendController;

class CountryController extends FrontendController
{
    public function index($slug) {
        $info = Taxonomy::where('slug', '=', $slug)
            ->firstOrFail();
        
        $items = Movie::with(['taxonomies'])
            ->select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'video_quality',
            'year',
            'genres',
            'countries',
            'tv_series',
            'current_episode',
            'max_episode',
        ])
            ->wherePublish()
            ->whereTaxonomy($info->id)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        
        return view('genre.index', [
            'title' => $info->name,
            'description' => $info->description,
            'items' => $items,
            'info' => $info,
        ]);
    }
}
