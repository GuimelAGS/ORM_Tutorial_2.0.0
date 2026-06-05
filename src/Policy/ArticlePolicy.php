<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Article;
use Authorization\IdentityInterface;

class ArticlePolicy
{
    public function canAdd(IdentityInterface $user, Article $article): bool
    {
        // Any authenticated user can create articles
        return true;
    }

    public function canEdit(IdentityInterface $user, Article $article): bool
    {
        return $this->isAuthor($user, $article);
    }

    public function canDelete(IdentityInterface $user, Article $article): bool
    {
        return $this->isAuthor($user, $article);
    }

    protected function isAuthor(IdentityInterface $user, Article $article): bool
    {
        // Use == (not ===) to handle int/string type differences from session
        return (int)$article->user_id === (int)$user->getIdentifier();
    }
}
