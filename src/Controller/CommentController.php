<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Post;
use App\Service\AccountDataService;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    private AccountDataService $accountDataService;
    private PostService $postService;

    public function __construct(AccountDataService $accountDataService,PostService $postService)
    {
        $this->accountDataService = $accountDataService;
        $this->postService = $postService;
    }

    /**
     * @Route ("/comment/{id}", name="add_comment" )
     */
    public function addComment(Request $request, Post $post):Response
    {
        $user = $this->accountDataService->getUserData();
        $commentText = $request->request->get('CommentText');
     $comment = $this->postService->commentOnPost($user,$commentText,$post);
      if ($request->isXmlHttpRequest()){
          return $this->render('wrapper_comment.html.twig',['comment'=>$comment]);
      }
      else{
          $this->redirectToRoute('home_page');
      }
    }
}