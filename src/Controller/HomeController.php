<?php


namespace App\Controller;


use App\Entity\Post;
use App\Form\PostType;
use App\Service\AccountDataService;
use App\Service\LocalFileUploadService;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends  AbstractController
{
    /**
     * @var PostService
     */
    private PostService  $postService;
    private AccountDataService $accountDataService;

    public function __construct(PostService $postService, AccountDataService  $accountDataService)
    {
        $this->postService = $postService;
        $this->accountDataService = $accountDataService;
    }

    /**
     * @Route("/home", name="home_page")
     * @param Request $request
     * @param LocalFileUploadService $uploadService
     * @return Response
     */
    public function Home(Request $request,LocalFileUploadService $uploadService): Response
    {
        $account = $this->accountDataService->getUserData();
        $form = $this->createForm(PostType::class,null,['action'=>'#']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            /** @var Post $post */
            $post = $form->getData();
            $postPhoto = $form->get('photo')->getData();
            if ($postPhoto){
               $fileName = $uploadService->uploadFile($postPhoto,LocalFileUploadService::PostPhoto);
               $post->setPhoto($fileName);
            }
            $post->setAccount($account);
            $this->postService->addPost($post);
            $form = $this->createForm(PostType::class,null,['action'=>'#']);
        }
        $posts = $this->postService->getAllPosts();
        if ($request->isXmlHttpRequest()){
            return $this->render('wrapper_post.html.twig',['post'=>$post,'account'=>$account]);
        }
        return $this->render('home.html.twig',['posts'=>$posts,'account'=>$account,'form'=>$form->createView()]);
    }
}