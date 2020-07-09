<?php

namespace chadclark\stocktype\graphql;


use craft\gql\base\GeneratorInterface;
use craft\gql\GqlEntityRegistry;
use craft\gql\TypeLoader;
use GraphQL\Type\Definition\Type;
use chadclark\stocktype\fields\TypeField;

class TypeFieldTypeGenerator implements GeneratorInterface
{
  /**
   * @inheritdoc
   */
  public static function generateTypes($context = null): array
  {
      /** @var TypeField $context */
      $typeName = self::getName($context);

      $properties = [
          'title' => Type::string(),
      ];

      $property = GqlEntityRegistry::getEntity($typeName)
          ?: GqlEntityRegistry::createEntity($typeName, new TypeFieldResolver([
              'name' => $typeName,
              'description' => 'This entity has all the Stocktype Field properties',
              'fields' => function () use ($properties) {
                  return $properties;
              },
          ]));

      TypeLoader::registerType($typeName, function () use ($property) {
          return $property;
      });

      return [$property];
  }

  /**
   * @inheritdoc
   */
  public static function getName($context = null): string
  {
      /** @var TypeField $context */
      return $context->handle . '_TypeField';
  }

}