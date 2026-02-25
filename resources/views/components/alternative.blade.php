<div class="col-6 text-center">
    <a href="{{ route('answer', Crypt::encryptString($capital)) }}" class="text-decoration-none text-center">
        <p class="response-option"> {{ $capital }}</p>
    </a>
</div>
