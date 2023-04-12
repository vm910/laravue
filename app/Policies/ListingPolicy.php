<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{

    public function before(?User $user, $ability)
    {
        if ($user?->is_admin /*&& $ability === 'update'*/) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Listing $listing)
    {
        if ($listing->by_user_id === $user?->id) {
            return true;
        }

        return $listing->sold_at === null
            ? Response::allow()
            : Response::deny('This listing is sold.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Listing $listing)
    {
        return $listing->sold_at === null && ($user->id === $listing->by_user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Listing $listing)
    {
        return $user->id === $listing->by_user_id
            ? Response::allow()
            : Response::deny('You do not own this listing.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Listing $listing)
    {
        return $user->id === $listing->by_user_id
            ? Response::allow()
            : Response::deny('You do not own this listing.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Listing $listing)
    {
        return $user->id === $listing->by_user_id
            ? Response::allow()
            : Response::deny('You do not own this listing.');
    }
}
