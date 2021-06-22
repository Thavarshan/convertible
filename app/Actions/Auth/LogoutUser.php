<?php

namespace App\Actions\Auth;

use Emberfuse\Scorch\Contracts\Actions\LogsoutUsers;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class LogoutUser extends AuthAction implements LogsoutUsers
{
    /**
     * Logout currently authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function logout(Request $request): void
    {
        $this->guard->logout();

        if ($request->hasSession()) {
            tap($request->session(), function (Session $session): void {
                $session->invalidate();

                $session->regenerateToken();
            });
        }
    }
}
