<?php

namespace App\Models\Concerns;
use Illuminate\Support\Str;

trait ConvertsMarkdownToHtml
{
    protected static function bootConvertsMarkdownToHtml () 
    {
        static::saving(function (self $model) {
            $model->fill([
                'html' => Str::markdown($model->body, [
                    'html_input' => 'strip',
                    'allow_unsafe_links' => false,
                    'max_nesting_level' => 5,
                ]),
            ]);
        });
    }
}
