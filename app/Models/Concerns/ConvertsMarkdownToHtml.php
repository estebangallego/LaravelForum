<?php

namespace App\Models\Concerns;
use Illuminate\Support\Str;

trait ConvertsMarkdownToHtml
{
    protected static function bootConvertsMarkdownToHtml () 
    {
        static::saving(function (self $model) {
            $markDownData = collect(self::getMarkdownToHtmlHtmlMap())
                ->flip()
                ->map(fn ($bodyColumn) => Str::markdown($model->$bodyColumn, [
                    'html_input' => 'strip',
                    'allow_unsafe_links' => false,
                    'max_nesting_level' => 5,
                ]));

            return $model->fill($markDownData->toArray());  
        });
    }

    protected static function getMarkdownToHtmlHtmlMap(): array {
        return [
            'body' => 'html',
        ];
    }
}
