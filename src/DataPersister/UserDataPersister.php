<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private $decoratedDataPersister;
    private $userPasswordEncoder;
    private $logger;

    public function __construct(
        DataPersisterInterface $decoratedDataPersister,
        UserPasswordEncoderInterface $userPasswordEncoder,
        LoggerInterface $logger
    ) {
        $this->decoratedDataPersister = $decoratedDataPersister;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->logger = $logger;
    }

    public function supports($data, array $context= []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context= [])
    {

        if (($context['item_operation_name'] ?? null) === 'put') {
            $this->logger->info(sprintf('User "%s" is being updated!', $data->getId()));
        }
        if(!$data->getId()) {
            $this->logger->info(sprintf('User %s just registered! Eureka!', $data->getEmail()));
        }
        if ($data->getPlainPassword()) {
            $data->setPassword(
                $this->userPasswordEncoder->encodePassword($data, $data->getPlainPassword())
            );
            $data->eraseCredentials();
        }

        $this->decoratedDataPersister->persist($data);

    }

    public function remove($data, array $context= [])
    {
        $this->decoratedDataPersister->remove($data);
    }
}
