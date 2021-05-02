<?php


namespace App\DataTransformer;


use ApiPlatform\Core\DataTransformer\DataTransformerInitializerInterface;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Dto\CheeseListingInput;
use App\Entity\CheeseListing;

class CheeseListingInputDataTransformer implements DataTransformerInterface, DataTransformerInitializerInterface
{

    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    public function transform($input, string $to, array $context = [])
    {
        $this->validator->validate($input);
        $cheeseListing = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE] ?? null;

        return $input->createOrUpdateEntity($cheeseListing);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof CheeseListing) {
            // already transformed
            return false;
        }

        return $to === CheeseListing::class && ($context['input']['class'] ?? null) === CheeseListingInput::class;
    }

    public function initialize(string $inputClass, array $context = [])
    {
        $entity = $context['object_to_populate'] ?? null;

        if ($entity && !$entity instanceof CheeseListing) {
            throw new \Exception(sprintf('Unexpected resource class "%s"', get_class($entity)));
        }

        return CheeseListingInput::createFromEntity($entity);
    }
}
