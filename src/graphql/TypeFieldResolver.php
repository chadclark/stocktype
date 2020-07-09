<?php

namespace chadclark\stocktype\graphql;

use craft\gql\base\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class TypeFieldResolver extends ObjectType
{

    /**
     * @inheritdoc
     */
    protected function resolve($source, $arguments, $context, ResolveInfo $resolveInfo)
    {
        $fieldName = $resolveInfo->fieldName;

        return $source->$fieldName;
    }
}