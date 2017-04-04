<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Send selected fields in response
 * Class UserTransformer
 * @package App\Transformers
 */

class UserTransformer extends TransformerAbstract {

    public function transform(User $user)
    {
        return [
            'id' => $user->id
        ];
    }

}
