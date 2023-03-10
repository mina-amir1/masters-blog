<?php

namespace App\Service;

use App\Contract\UploadFileInterface;
use App\Entity\Account;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountDataService
{

    private AccountRepository $accountRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(AccountRepository  $accountRepository, EntityManagerInterface $entityManager)
    {
        $this->accountRepository = $accountRepository;
        $this->entityManager = $entityManager;
    }

    public function getUserData(?Account $user = null ): ?Account
    {
        return $this->accountRepository->find(1);
    }

    public function updateUserData(Account $account)
    {
        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }

}