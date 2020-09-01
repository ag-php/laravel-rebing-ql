<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Admin\Query\Tag;

use App\Base\Globals\Langs;
use App\Base\Logic\Search\Classes\TextSearch;
use App\Base\Logic\Search\Classes\TranslationSearch;
use App\Base\Logic\Search\Pagination\Items\PaginationLang;
use App\Base\Logic\Search\Pagination\Items\PaginationOrderBy;
use App\Base\Logic\Search\Pagination\PaginationClassSearchLang;
use App\Base\Model\Generic\Tag;
use App\Base\Model\Lang\VText;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Rebing\GraphQL\Support\Query;

class TagsQuery extends Query
{
    protected array $columns;
    protected array $orderByColumns;

    protected $attributes = [
        'name'        => 'tags',
        'description' => 'A query to get the Tags Type',
    ];

    public function __construct()
    {
        $tag = new Tag();
        $this->columns = $tag->getPublicColumns();
        $this->orderByColumns = array_merge(
            $this->columns,
            (new VText())->getPublicColumns()
        );
    }

    public function type(): Type
    {
        return GraphQL::paginate('TagType');
    }

    public function args(): array
    {
        $paginationClass = new PaginationClassSearchLang(
            new PaginationOrderBy(
                'generic.tag.tag_id',
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
        $query = Tag::select($this->columns);
        $query->orderBy($args['orderBy'], $args['order']);

        $translationSearch = new TranslationSearch('generic.tag.translation_id', $args['lang_id']);
        $translationSearch->query($query);

        if (strlen($args['search']) > 0) {
            $textSearch = new TextSearch($args['search'], 'vtext.text');
            $textSearch->query($query);
        }

        return $query->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
