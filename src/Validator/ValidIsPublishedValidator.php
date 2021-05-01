<?php

namespace App\Validator;

use App\Entity\CheeseListing;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidIsPublishedValidator extends ConstraintValidator
{

    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\ValidIsPublished */
        if (!$value instanceof CheeseListing) {
            throw new \LogicException('Only CheeseListing is supported');
        }

        $originalData = $this->entityManager
            ->getUnitOfWork()
            ->getOriginalEntityData($value);

        $previousIsPublished = ($originalData['isPublished'] ?? false);
        if ($previousIsPublished === $value->getIsPublished()) {
            // isPublished didn't change!

            return;
        }

        if ($value->getIsPublished()) {
            // we are publishing!
            // don't allow short descriptions, unless you are an admin
            if (strlen($value->getDescription()) < 100 && !$this->security->isGranted('ROLE_ADMIN')) {
                $this->context->buildViolation('Cannot publish: description is too short!')
                    ->atPath('description')
                    ->addViolation();
            }

            return;
        }

        // we are UNpublishing
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            // you can return a 403
            //throw new AccessDeniedException('Only admin users can unpublish');

            // or a normal validation error
            $this->context->buildViolation('Only admin users can unpublish')
                ->addViolation();
        }
    }
}
