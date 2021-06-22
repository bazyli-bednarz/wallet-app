<?php
/**
 * wallet-app.
 *
 * (c) Bazyli Bednarz, 2021
 */

namespace App\Security\Voter;

use App\Entity\Operation;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OperationVoter
 *
 * @package App\Security\Voter
 */
class OperationVoter extends Voter
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
        return in_array($attribute, ['VIEW', 'EDIT', 'DELETE']) && $subject instanceof Operation;
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

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'VIEW':
            case 'EDIT':
            case 'DELETE':
                return $this->isAuthor($subject, $user);
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
        return $subject->getWallet()->getAuthor() === $user;
    }
}
