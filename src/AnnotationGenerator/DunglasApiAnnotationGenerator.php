<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator\AnnotationGenerator;

use ApiPlatform\SchemaGenerator\TypesGenerator;

/**
 * Generates Iri annotations provided by DunglasApiBundle.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @see https://github.com/dunglas/DunglasApiBundle
 */
class DunglasApiAnnotationGenerator extends AbstractAnnotationGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generateClassAnnotations(string $className): array
    {
        $resource = $this->classes[$className]['resource'];

        return [sprintf('@Iri("%s")', $resource->getUri())];
    }

    /**
     * {@inheritdoc}
     */
    public function generateFieldAnnotations(string $className, string $fieldName): array
    {
        return $this->classes[$className]['fields'][$fieldName]['isCustom'] ? [] : [sprintf('@Iri("https://schema.org/%s")', $fieldName)];
    }

    /**
     * {@inheritdoc}
     */
    public function generateUses(string $className): array
    {
        $resource = $this->classes[$className]['resource'];

        $subClassOf = $resource->get('rdfs:subClassOf');
        $typeIsEnum = $subClassOf && $subClassOf->getUri() === TypesGenerator::SCHEMA_ORG_ENUMERATION;

        return $typeIsEnum ? [] : ['Dunglas\ApiBundle\Annotation\Iri'];
    }
}
