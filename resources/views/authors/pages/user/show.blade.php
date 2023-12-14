@extends('authors.main._index')

@section('css')
@endsection

@section('js')
<script>
    function validarEmail(email) {
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regexEmail.test(email);
    }

    $('#submitFormProfile').on('submit', (e) => {
        e.preventDefault();

        const form = $(e.currentTarget);

        const name = form.find('#name');
        const email = form.find('#email');
        const password = form.find('#password');
        const confirmPassword = form.find('#confirm-password');

        if(password.val().trim() !== ""){
            if (password.val() !== confirmPassword.val()) {
                password.addClass('is-invalid');
                confirmPassword.addClass('is-invalid');

                showCustomToast("danger", {
                    title: "<?= __('messages.form.error.title_error') ?>",
                    message: "<?= __('messages.form.error.passwords_not_same') ?>",
                });

                return;
            } else {
                password.removeClass('is-invalid');
                confirmPassword.removeClass('is-invalid');
            }
        }

        var errors = [];

        if (name.val().trim() === "") {
            name.addClass('is-invalid');
            errors.push("name: error");
        }

        if (email.val().trim() === "" || !validarEmail(email.val())) {
            email.addClass('is-invalid');
            errors.push("email: error");
        }

        if (errors.length > 0) {
            showCustomToast("danger", {
                title: "<?= __('messages.form.error.title_error') ?>",
                message: "<?= __('messages.form.error.invalid_or_null_fields') ?>",
            });
            return;
        }

        form.unbind('submit').submit();
    });
</script>

@if(session('success'))
    <script>
        showCustomToast("success", {
            title: "<?= __('messages.form.success.update.title') ?>",
            message: "<?= __('messages.form.success.update.message') ?>",
        });
    </script>
@endif

@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>{{__('messages.my_profile.title')}}</h1>
                        <span>{{__('messages.my_profile.subtitle')}}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-8">
                                <form id="submitFormProfile" method="POST" action="{{route('AppAuthor.user.profile.update')}}">
                                    @csrf
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">{{__('messages.form.labels.name')}} <code>*</code></label>
                                            <input value="{{$user["name"]}}" type="text" class="form-control" id="name" name="name" placeholder="John">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">{{__('messages.form.labels.email')}} <code>*</code></label>
                                            <input value="{{$user["email"]}}" type="email" class="form-control" name="email" id="email" placeholder="examplo@exemplo.com">
                                            <div id="settingsEmailHelp" class="form-text">{{__('messages.form.text.email')}}</div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">{{__('messages.form.labels.password')}} </label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                            <div class="form-text">{{__('messages.form.text.password')}}</div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <label for="confirm-password" class="form-label">{{__('messages.form.labels.confirm_password')}} </label>
                                            <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                            <div style="margin-top: -20px;" class="invalid-tooltip">
                                                {{__('messages.form.text.password_not_match')}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <button class="btn btn-primary">{{__('messages.form.buttons.save')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
