<?php

namespace App\Service;


use App\Contract\UploadFileInterface;
use App\Entity\Account;
use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PostService
{

    private PostRepository $postRepository;
    private EntityManagerInterface $entityManager;

    public function __construct( PostRepository  $postRepository, EntityManagerInterface $entityManager)
    {

        $this->postRepository = $postRepository;
        $this->entityManager = $entityManager;
    }

    public function addPost(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function getAllPosts(UserInterface $user = null ):array
    {
        return $this->postRepository->getRecentPosts();
    }

    public function likePost()
    {

    }

    public function commentOnPost(Account $account,string $commentText,Post $post):Comment
    {
        $comment = new Comment();
        $comment->setAccount($account)
            ->setCommentText($commentText)
        ->setPost($post);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
        return $comment;
    }
}