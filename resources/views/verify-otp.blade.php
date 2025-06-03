<form method="POST" action="{{ route('otp.verify', ['user' => $user->id]) }}">
    @csrf
    <label>Masukkan Kode OTP:</label>
    <input type="text" name="otp" required>
    <button type="submit">Verifikasi</button>
</form>
