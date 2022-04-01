<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Flags\Access;

use Flarum\Extension\ExtensionManager;
use Flarum\Tags\Tag;
use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;

class ScopeFlagVisibility
{
    /**
     * @var ExtensionManager
     */
    protected $extensions;

    public function __construct(ExtensionManager $extensions)
    {
        $this->extensions = $extensions;
    }

    public function __invoke(User $actor, Builder $query)
    {
        if (!$actor->hasPermission('discussion.viewFlags')) {
            $query->where('flags.user_id', $actor->id);
        }

        if ($actor->hasPermission('user.viewPrivateDiscussionsWhenFlagged')) {
            $query->orWhere('discussion.is_private', 1);
        }
    }
}