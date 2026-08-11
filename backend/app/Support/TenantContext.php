<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class TenantContext
{
    public static function ownerId(?User $user): ?int
    {
        if (! $user) {
            return null;
        }

        if ($user->role === 'owner') {
            return $user->id;
        }

        if (! in_array($user->role, ['cashier', 'manager'], true)) {
            return null;
        }

        $ownerId = DB::table('owner_employees')
            ->where('email', $user->email)
            ->value('owner_user_id');

        return $ownerId ? (int) $ownerId : null;
    }

    public static function company(?User $user): ?object
    {
        $ownerId = self::ownerId($user);

        return $ownerId
            ? DB::table('owner_companies')->where('owner_user_id', $ownerId)->first()
            : null;
    }
}