<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting

namespace App\Base\Exceptions;

use App\Base\Util\StringBetween;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use GraphQL\Error\Error;
use Illuminate\Support\Arr;

class GraphQLExceptions
{
    public static function formatError(Error $error)
    {
        $previous = $error->getPrevious();
        if (! $previous) {
            return [
                'message' => $error->getMessage(),
            ];
        }

        $previousClass = get_class($previous);
        switch ($previousClass) {
        case 'Rebing\\GraphQL\\Error\\ValidationError':
            return self::getValidation($error);
        case 'Illuminate\Database\QueryException':
            return self::getQueryException($error);
        case 'App\\Base\\Exceptions\\MessageError':
            return self::getMessageError($error);
        default:
            return self::getError($error);
        }
    }

    private static function getValidation(Error $error): array
    {
        return [
            'message'    => $error->getMessage(),
            // @phpstan-ignore-next-line
            'validation' => $error->getPrevious()->getValidatorMessages(),
        ];
    }

    private static function getMessageError(Error $e): array
    {
        return [
            'code'    => $e->getPrevious()->getCode(),
            'message' => $e->getMessage(),
            'type'    => 'messageError',
        ];
    }

    private static function getQueryException(Error $e) : array
    {
        // FK constraint violation.
        if (
            $e->getPrevious()->getCode() == 23503
            && strpos($e->getMessage(), 'still referenced from table') !== false
            && strpos($e->getMessage(), 'SQL: delete from') !== false
        ) {
            $message = StringBetween::find($e->getMessage(), 'DETAIL:', '(SQL');

            return ['message' => __('graphql.you_cannot_delete_it', ['detail' => $message])];
        }

        // Duplicate key value violates unique constraint.
        if (
             $e->getPrevious()->getCode() == 23505
             && strpos($e->getMessage(), 'already exists') !== false
            ) {
            $message = StringBetween::find($e->getMessage(), 'DETAIL:', '(SQL');

            return ['message' => __('graphql.unique_error', ['detail' => $message])];
        }

        //Trigger Errors
        if ($e->getPrevious()->getCode() == 'TBLOP') {
            return ['message' => __('select_option.tblop')];
        }
        if ($e->getPrevious()->getCode() == 'IGADE') {
            return ['message' => __('select_option.igade')];
        }
        //Trigger Errors -> The value doesn't exists.
        if ($e->getPrevious()->getCode() == 'C0002') {
            $message = StringBetween::find($e->getMessage(), 'ERROR:', 'CONTEXT');
            $message = stripslashes($message);

            return ['message' => __('graphql.C0002', ['detail' => $message])];
        }

        return self::getError($e);
    }

    private static function getError(Error $e) : array
    {
        if (\App::environment() == 'production') {
            Bugsnag::notifyException($e->getPrevious());

            return [
                'message' => __('graphql.error500'),
            ];
        }

        return [
            'code'    => $e->getPrevious()->getCode(),
            'line'    => $e->getPrevious()->getLine(),
            'file'    => $e->getPrevious()->getFile(),
            'class'   => get_class($e->getPrevious()),
            'message' => $e->getMessage(),
            'trace'   => collect($e->getPrevious()->getTrace())->map(
                function ($trace) {
                    return Arr::except($trace, ['args']);
                }
            )->all(),
        ];
    }
}
