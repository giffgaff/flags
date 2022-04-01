<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Flags\Access;

use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;

class ScopeFlagVisibility
{
    public function __invoke(User $actor, Builder $query)
    {
        if (!$actor->hasPermission('discussion.viewFlags')) {
            $query->where('flags.user_id', $actor->id);
        }

        if ($actor->hasPermission('user.viewPrivateDiscussionsWhenFlagged')) {
            $query->orWhere('discussions.is_private', 1);
        } else {
            $query->where('discussions.is_private', 0);
        }
    }
}
