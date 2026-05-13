<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class SocialAuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }
    /**
     * Redirect the user to the provider authentication page.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            $user = User::where('social_id', $socialUser->id)
                        ->where('social_type', $provider)
                        ->first();
            
            if (!$user) {
                // Check if user with same email exists
                $user = User::where('email', $socialUser->email)->first();
                
                if ($user) {
                    // Update existing user with social info
                    $user->update([
                        'social_id' => $socialUser->id,
                        'social_type' => $provider,
                        'avatar' => $user->avatar ?? $socialUser->avatar,
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $socialUser->name ?? $socialUser->nickname,
                        'username' => strtolower(str_replace(' ', '', $socialUser->nickname ?? $socialUser->name)) . rand(100, 999),
                        'email' => $socialUser->email,
                        'social_id' => $socialUser->id,
                        'social_type' => $provider,
                        'avatar' => $socialUser->avatar,
                        'role' => 'client', // Default role for social login
                        'is_active' => true,
                    ]);
                }
            }
            
            Auth::login($user);
            
            return redirect()->route('dashboard')->with('success', 'Berhasil masuk dengan ' . ucfirst($provider));
            
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk dengan ' . ucfirst($provider) . ': ' . $e->getMessage());
        }
    }

    /**
     * Handle Firebase Login (ID Token verification)
     */
    public function handleFirebaseLogin(\Illuminate\Http\Request $request)
    {
        try {
            $idToken = $request->input('id_token');
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken);
            $firebaseUid = $verifiedIdToken->claims()->get('sub');
            
            // Get user info from token claims or Firebase Auth
            $socialUser = $this->firebaseAuth->getUser($firebaseUid);
            
            $user = User::where('social_id', $firebaseUid)
                        ->where('social_type', 'google') // Firebase Google
                        ->first();
            
            if (!$user) {
                $user = User::where('email', $socialUser->email)->first();
                
                if ($user) {
                    $user->update([
                        'social_id' => $firebaseUid,
                        'social_type' => 'google',
                        'avatar' => $socialUser->photoUrl ?? $user->avatar,
                    ]);
                } else {
                    $user = User::create([
                        'name' => $socialUser->displayName ?? explode('@', $socialUser->email)[0],
                        'username' => strtolower(str_replace(' ', '', $socialUser->displayName ?? 'user')) . rand(100, 999),
                        'email' => $socialUser->email,
                        'social_id' => $firebaseUid,
                        'social_type' => 'google',
                        'avatar' => $socialUser->photoUrl,
                        'role' => 'client',
                        'is_active' => true,
                    ]);
                }
            }
            
            Auth::login($user);
            
            return response()->json([
                'success' => true,
                'redirect' => route('dashboard')
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Firebase Auth Error: ' . $e->getMessage()
            ], 401);
        }
    }
}
