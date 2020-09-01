<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Admin\Query\Translation;

use App\Base\Globals\Langs;
use App\Base\Logic\Search\Classes\{
    TextSearch,
    TranslationSearch
};
use App\Base\Logic\Search\Pagination\Items\{
    PaginationLang,
    PaginationOrderBy
};
use App\Base\Logic\Search\Pagination\PaginationClassSearchLangTags;
use App\Base\Model\Lang\Translation;
use App\Base\Model\Lang\VText;
use App\Base\Classes\ModelColumns;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Rebing\GraphQL\Support\Query;

class TranslationsQuery extends Query
{
    protected array $columns;
    protected array $orderByColumns;

    protected $attributes = [
        'name'        => 'translations',
        'description' => 'A query to get the Translations Type',
    ];

    public function __construct()
    {
        $translationModelColumns = new ModelColumns(new Translation());
        $this->columns = $translationModelColumns->public();
        $vTextModelColumns = new ModelColumns(new VText());
        $this->orderByColumns = array_merge(
            $this->columns,
            $vTextModelColumns->public()
        );
    }

    public function type(): Type
    {
        return GraphQL::paginate('TranslationType');
    }

    public function args(): array
    {
        $paginationClass = new PaginationClassSearchLangTags(
            new PaginationOrderBy(
                'lang.translation.translation_id',
                $this->orderByColumns
            ),
            new PaginationLang(
                Langs::getDefault()
            )
        );

        return $paginationClass->toArray();
    }

    public function resolve(?Object $root, array $args): LengthAwarePaginator
    {
        $query = Translation::select($this->columns);
        $query->orderBy($args['orderBy'], $args['order']);

        $translationSearch = new TranslationSearch('lang.translation.translation_id', $args['lang_id']);
        $translationSearch->query($query);

        if (strlen($args['search']) > 0) {
            $textSearch = new TextSearch($args['search'], 'vtext.text');
            $textSearch->query($query);
        }

        return $query->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
