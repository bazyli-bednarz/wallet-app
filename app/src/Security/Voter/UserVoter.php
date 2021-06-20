<?php
/**
 * User Voter.
 */

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User Voter class.
 *
 * Class UserVoter
 */
class UserVoter extends Voter
{
    /**
     * Permissions.
     *
     * @param string $attribute
     * @param mixed  $subject
     *
     * @return bool
     */
    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, ['VIEW', 'EDIT', 'DELETE', 'MANAGE']) && $subject instanceof User;
    }

    /**
     * Voting mechanism.
     *
     * @param string         $attribute
     * @param mixed          $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'VIEW':
            case 'EDIT':
            case 'DELETE':
                return $this->isAuthor($subject, $user);
            case 'MANAGE':
                return $this->isAdminorOwner($subject, $user);
            default:
                return false;
        }
    }

    /**
     * Check if is an author.
     *
     * @param $subject
     * @param User $user
     *
     * @return bool
     */
    private function isAuthor($subject, User $user): bool
    {
        return $subject->getId() === $user->getId();
    }

    /**
     * Check if is an author or admin.
     *
     * @param $subject
     * @param User $user
     *
     * @return bool
     */
    private function isAdminOrOwner($subject, User $user): bool
    {
        return ($subject->getId() === $user->getId()) || (in_array('ROLE_ADMIN', $user->getRoles()));

    }
}
