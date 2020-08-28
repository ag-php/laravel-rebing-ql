<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Publics\Query;

use App\Base\Logic\Search\Classes\TextSearch;
use App\Base\Logic\Search\Pagination\Items\PaginationOrderBy;
use App\Base\Logic\Search\Pagination\PaginationClassSearch;
use App\Base\Model\Lang\Lang;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class LangsQuery extends Query
{
    protected $attributes = [
        'name'        => 'langs',
        'description' => 'A query to get the Langs',
    ];
    protected $columns;

    public function __construct()
    {
        $this->columns = (new Lang())->getPublicColumns();
    }

    public function type(): Type
    {
        return GraphQL::paginate('LangType');
    }

    public function args(): array
    {
        $paginationClass = new PaginationClassSearch(
            new PaginationOrderBy(
                'lang.lang.lang_id',
                $this->columns
            )
        );
        $args = $paginationClass->toArray();

        $args['active'] = [
            'name' => 'active',
            'type' => Type::boolean(),
        ];

        return $args;
    }

    public function resolve($root, array $args)
    {
        $query = Lang::select($this->columns);
        $query->orderBy($args['orderBy'], $args['order']);

        if (strlen($args['search']) > 0) {
            $textSearch = new TextSearch($args['search'], 'security.user.name');
            $textSearch->query($query);
        }

        if (array_key_exists('active', $args)) {
            $query->where('active', $args['active']);
        }

        return $query->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
