<x-guest-layout>
    <div class="mdl-card mdl-card__login mdl-shadow--2dp">
        <div class="mdl-card__supporting-text color--dark-gray">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                    <div class="center-align">
                        <x-authentication-card-logo />
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                    <span class="login-name text-color--white">Sign in</span>
                    <span class="login-secondary-text text-color--smoke">Masukkan data di kolom untuk masuk ke aplikasi</span>
                </div>

                <x-validation-errors class="mb-4 customerrorlogin" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                            <input class="mdl-textfield__input" type="text" id="e-mail" name="email" :value="old('email')" autofocus autocomplete="username">
                            <label class="mdl-textfield__label" for="e-mail">Email / Username</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                            <input class="mdl-textfield__input" type="password" id="password" name="password" autocomplete="current-password">
                            <label class="mdl-textfield__label" for="password">Password</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone submit-cell">
                        <div class="mdl-layout-spacer"></div>
                        <x-button class="mdl-button mdl-js-button mdl-button--raised color--light-blue">
                            Masuk
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
