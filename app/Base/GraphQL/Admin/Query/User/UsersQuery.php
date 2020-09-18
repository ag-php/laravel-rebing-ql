<?php

namespace App\Base\GraphQL\Admin\Query\User;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use App\Base\Classes\ModelColumns;
use App\Base\Model\Security\User;
use App\Base\Logic\Search\Classes\TextSearch;
use App\Base\Logic\Search\Pagination\PaginationClassSearch;
use App\Base\Logic\Search\Pagination\Items\PaginationOrderBy;

class UsersQuery extends Query
{

    protected array $columns;

    protected $attributes = [
        'name'        => 'users',
        'description' => 'A query to get the list of users',
    ];

    public function __construct()
    {
        $tagModelColumns = new ModelColumns(new User());
        $this->columns = $tagModelColumns->public();
    }

    public function type(): Type
    {
        return GraphQL::paginate('UserType');

    }

    public function args(): array
    {
        $paginationClass =  new PaginationClassSearch(
            new PaginationOrderBy(
                'security.user.user_id',
                $this->columns
            )
        );
        return $paginationClass->toArray();
    }

    public function resolve(?Object $root, array $args): LengthAwarePaginator
    {
        $query = User::select($this->columns);
        $query->orderBy($args['orderBy'], $args['order']);

        if (strlen($args['search']) > 0) {
            $textSearch = new TextSearch($args['search'], 'security.user.name');
            $textSearch->query($query);
        }

        return $query->paginate($args['limit'], ['*'], 'page', $args['page']);

    }

}
