<?php


namespace App\Controller;


use App\Entity\Account;
use App\Form\ForgetPasswordType;
use App\Form\AccountType;
use App\Form\UserLoginType;
use App\Service\AccountService;
use App\Service\LocalFileUploadService;
use App\Service\PasswordHasherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAuthController extends  AbstractController
{
    /**
     * @var AccountService
     */
    private AccountService $accountService;
    private EntityManagerInterface $entityManager;

    public function __construct(AccountService $accountService,EntityManagerInterface $entityManager)
    {
        $this->accountService = $accountService;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/login",name="login_page")
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $form = $this->createForm(UserLoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            if ($data['email'] === 'test@test.com' && $data['password']==='123'){
               return $this->redirectToRoute('home_page');
            }
            else{
                $this->addFlash('error','invalid username or password');
                return $this->render('login.html.twig',['form'=>$form->createView()]);
            }
        }
        return $this->render('login.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/register",name="register_page")
     * @return Response
     */
    public function registerAction(Request $request, PasswordHasherService $passwordHasher,LocalFileUploadService $uploadService)
    {
        $form = $this->createForm(AccountType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $userPhoto = $form->get('userPhoto')->getData();
            $plainPass = $form->get('plainPassword')->getData();
            /** @var Account $data */
            $Accountdata = $form->getData();
            $Accountdata->setPassword($passwordHasher->hashPassword($plainPass));
            $Accountdata->setAvatar($uploadService->uploadFile($userPhoto));
            $this->entityManager->persist($Accountdata);
            $this->entityManager->flush();
            return $this->redirectToRoute('home_page');
        }
        return $this->render('register.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/forget_password",name="forget_password_page")
     * @return Response
     */
    public function forgetPasswordAction(Request $request)
    {
        $form = $this->createForm(ForgetPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $email = $form->get('email')->getData();
            $account = $this->accountService->getAccountByEmail($email);
            if ($account){
                $this->accountService->sendRestPasswordLink($account);
                $this->addFlash('success',"Reset Password email is sent Successfully");
                return $this->redirectToRoute('login_page');
            }
            else{
                $this->addFlash('error',"Invalid Email");
                return $this->render('forget_password.html.twig',['form'=>$form->createView()]);
            }
        }
        return $this->render('forget_password.html.twig',['form'=>$form->createView()]);
    }
}