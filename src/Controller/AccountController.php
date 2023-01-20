<?php


namespace App\Controller;


use App\Entity\Account;
use App\Form\AccountType;
use App\Service\AccountDataService;
use App\Service\FollowService;
use App\Service\LocalFileUploadService;
use App\Service\PostService;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @var PostService
     */
    private PostService  $postService;
    /**
     * @var AccountDataService
     */
    private  AccountDataService  $accountDataService;
    /**
     * @var FollowService
     */
    private FollowService  $followService;

    public function __construct(PostService $postService, AccountDataService $accountDataService, FollowService $followService)
    {
        $this->postService = $postService;
        $this->accountDataService = $accountDataService;
        $this->followService = $followService;
    }

    /**
     * @Route("/profile",name="profile_page")
     * @return Response
     */
    public function getProfile(Request $request, LocalFileUploadService $uploadService)
    {
        $userAccount  = $this->accountDataService->getUserData();
        $form = $this->createForm(AccountType::class,$userAccount);
        $form->remove('plainPassword');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $userPhoto = $form->get('userPhoto')->getData();
            if ($userPhoto){
               $photoName = $uploadService->uploadFile($userPhoto);
               $userAccount->setAvatar($photoName);
            }
            $this->accountDataService->updateUserData($userAccount);
            $this->addFlash('success','Your profile has been updated');
        }
        return $this->render('profile.html.twig',['account'=>$userAccount, 'form'=>$form->createView()]);
    }

    /**
     * @Route("/profile/{id}",name="profile_page_view")
     * @return Response
     */
    public function viewProfile(Account $account)
    {

        return $this->render('profile_view.html.twig', ['account' => $account]);
    }

    /**
     * @Route("/account_list",name="account_list")
     * @return Response
     */
    public function listAction()
    {
        return $this->render('account_list.html.twig');
    }
}