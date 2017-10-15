<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $scope = $this->getCurrentScope()->getIdentifier();

        return [
            'id'   => $user->id,
            'name'   => $user->name,
            'avatar' => $user->avatar($scope === 'users' || $scope == 'parent.users' ? 25 : 45)
        ];
    }
}
