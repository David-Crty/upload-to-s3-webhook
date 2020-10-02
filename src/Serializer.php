<?php


namespace App;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

class Serializer
{
    public function serialize($data, string $format, array $context = []): string
    {
        $symfonySerializer = $this->getSerializer();
        return $symfonySerializer->serialize($data, $format, $context);
    }
    
    public function getSerializer(){
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
    
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $encoder = new JsonEncoder();
    
        return new SymfonySerializer([$normalizer], [$encoder]);
    }
}