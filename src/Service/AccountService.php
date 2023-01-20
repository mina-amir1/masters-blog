<?php

namespace App\Service;

use App\Entity\Account;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountService
{
    /**
     * @var SendEmailService
     */
    private $emailService;
    private AccountRepository $accountRepository;

    public function __construct(SendEmailService $emailService,AccountRepository $accountRepository)
    {
        $this->emailService = $emailService;
        $this->accountRepository = $accountRepository;
    }

    public function registerNewUser()
    {
    }

    public function sendRestPasswordLink(Account $account)
    {

    }
    public function getAccountByEmail(string $email): ?Account
    {
        return $this->accountRepository->findOneBy(['email'=>$email]);
    }

}