Hello {{ $user->name }}
You changed your email, so we need to verify this new address. please use the link blow:
{{ route('verify', $user->verification_token) }}
