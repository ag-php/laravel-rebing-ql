<?php

declare(strict_types=1);

namespace App\Base\Exceptions;

use App\Base\Util\StringBetween;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use GraphQL\Error\Error;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Error\ValidationError;

class GraphQLExceptions
{
    public static function formatError(Error $error): array
    {
        if (! $error->getPrevious()) {
            return [
                'message' => $error->getMessage(),
            ];
        }

        $previousError = $error->getPrevious();
        if ($previousError instanceof ValidationError) {
            return self::getValidation($error, $previousError);
        }

        if ($previousError instanceof QueryException) {
            return self::getQueryException($error, $previousError);
        }

        if ($previousError instanceof MessageError) {
            return self::getMessageError($error, $previousError);
        }

        // @phpstan-ignore-next-line
        return self::getError($error, $previousError);
    }

    private static function getValidation(Error $error, ValidationError $validatorError): array
    {
        return [
            'message'    => $error->getMessage(),
            'validation' => $validatorError->getValidatorMessages(),
        ];
    }

    private static function getMessageError(Error $e, MessageError $messageError): array
    {
        return [
            'code'    => $messageError->getCode(),
            'message' => $e->getMessage(),
            'type'    => 'messageError',
        ];
    }

    private static function getQueryException(Error $e, QueryException $queryException) : array
    {
        // FK constraint violation.
        if (
            $queryException->getCode() == 23503
            && strpos($e->getMessage(), 'still referenced from table') !== false
            && strpos($e->getMessage(), 'SQL: delete from') !== false
        ) {
            $message = StringBetween::find($e->getMessage(), 'DETAIL:', '(SQL');

            return ['message' => __('graphql.you_cannot_delete_it', ['detail' => $message])];
        }

        // Duplicate key value violates unique constraint.
        if (
             $queryException->getCode() == 23505
             && strpos($e->getMessage(), 'already exists') !== false
            ) {
            $message = StringBetween::find($e->getMessage(), 'DETAIL:', '(SQL');

            return ['message' => __('graphql.unique_error', ['detail' => $message])];
        }

        //Trigger Errors
        if ($queryException->getCode() == 'TBLOP') {
            return ['message' => __('select_option.tblop')];
        }

        if ($queryException->getCode() == 'IGADE') {
            return ['message' => __('select_option.igade')];
        }

        //Trigger Errors -> The value doesn't exists.
        if ($queryException->getCode() == 'C0002') {
            $message = StringBetween::find($e->getMessage(), 'ERROR:', 'CONTEXT');
            $message = stripslashes($message);

            return ['message' => __('graphql.C0002', ['detail' => $message])];
        }

        return self::getError($e, $queryException);
    }

    private static function getError(Error $baseError, \Exception $error) : array
    {
        if (\App::environment() == 'production') {
            Bugsnag::notifyException($error);

            return [
                'message' => __('graphql.error500'),
            ];
        }

        return [
            'code'    => $error->getCode(),
            'line'    => $error->getLine(),
            'file'    => $error->getFile(),
            'class'   => get_class($error),
            'message' => $baseError->getMessage(),
            'trace'   => collect($error->getTrace())->map(
                function ($trace) {
                    return Arr::except($trace, ['args']);
                }
            )->all(),
        ];
    }
}
