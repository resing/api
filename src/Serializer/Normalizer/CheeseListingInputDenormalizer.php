<?php


namespace App\Serializer\Normalizer;


use App\Dto\CheeseListingInput;
use App\Entity\CheeseListing;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CheeseListingInputDenormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
{

    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return $this->objectNormalizer->denormalize($data, $type, $format, $context);
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === CheeseListingInput::class;
    }
}
