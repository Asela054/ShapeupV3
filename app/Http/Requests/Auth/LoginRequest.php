<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Normal Laravel auth (bcrypt/argon)
        $authenticated = false;
        try {
            $authenticated = Auth::attempt([
                'email' => $this->input('username'),
                'password' => $this->input('password')
            ], $this->boolean('remember'));
        } catch (\RuntimeException $e) {
            // Ignore hasher exception for legacy non-bcrypt passwords and continue with MD5 fallback.
            $authenticated = false;
        }

        if ($authenticated) {
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // Legacy MD5 fallback for old users
        $user = User::query()
            ->where('status', 1)
            ->where('email', (string) $this->input('username'))
            ->first();

        if ($user && hash_equals((string) $user->password, md5((string) $this->input('password')))) {
            // Upgrade hash to bcrypt transparently after successful legacy login
            $user->password = Hash::make((string) $this->input('password'));
            $user->updatedatetime = now();
            $user->save();

            Auth::login($user, $this->boolean('remember'));
            RateLimiter::clear($this->throttleKey());
            return;
        }

        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => 'Too many login attempts. Please try again in '.$seconds.' seconds.',
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('username')).'|'.$this->ip());
    }
    
}
