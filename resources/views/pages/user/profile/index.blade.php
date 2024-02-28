@extends('main._index')

@section('css')
<style>

    .btn-close {
        width: 0.3em!important;
        height: 0.3em!important;
    }

</style>
@endsection

@section('js')


<script>

    $("form[name='submit-user-update']").on('submit', (e) => {
        event.preventDefault();
        const form = $(e.target);

        const data = [
            form.find("input[name='settingsInputFirstName']"),
            form.find("input[name='settingsInputEmail']"),
            form.find("input[name='password']"),
            form.find("input[name='password_confirmation']"),
        ];

        data.forEach((item) => {
            if(item.value===""){
                item.addClass("is-invalid");
            }else{
                item.removeClass("is-invalid");
            }


            if(item.getAttribute('type')==="email"){

            }
        });

        if(data.name == "" || data.email == ""){
            showCustomToast("danger", {
                title: "Algo deu errado",
                message: "Os campos nome e e-mail são obrigatórios",
            });
            return false;
        }



        if(data.password != data.password_confirmation){
            showCustomToast("danger", {
                title: "Algo deu errado",
                message: "As senhas devem ser iguais",
            });
            return false;
        }

        $.ajax({
            url: "{{route('user.update')}}",
            type: "PUT",
            data: data,
            success: (response) => {
                console.log(response);
                if (response.status == 200) {
                    showCustomToast("success", {
                        title: "Uhuul!",
                        message: "Usuário atualizado com sucesso",
                    });
                } else {
                    showCustomToast("danger", {
                        title: "Algo deu errado",
                        message: "Usuário atualizado com sucesso",
                    });
                }
            },
            error: (response) => {
                showCustomToast("danger", {
                    title: "Algo deu errado",
                    message: "Usuário atualizado com sucesso",
                });
            }
        })
    })
</script>
@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description page-description-tabbed">
                            <h1>Configuração</h1>

                            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="hoaccountme" aria-selected="true">Perfil</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button disabled class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">Segurança</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button disabled class="nav-link" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#integrations" type="button" role="tab" aria-controls="integrations" aria-selected="false">Integração</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <form name="submit-user-update" action="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="name" class="form-label">Nome <code>*</code></label>
                                                    <input value="{{Auth::user()->name}}" type="text" class="form-control" id="name" name="name" placeholder="John">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label">E-mail <code>*</code></label>
                                                    <input value="{{Auth::user()->email}}" type="email" class="form-control" name="email" id="email" placeholder="examplo@exemplo.com">
                                                    <div id="settingsEmailHelp" class="form-text">O e-mail deve ser válido</div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <label for="settingsInputFirstName" class="form-label">Senha</label>
                                                    <input type="password" class="form-control" name="password" placeholder="**********">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="settingsInputEmail" class="form-label">Confirmar senha</label>
                                                    <input type="password" class="form-control" placeholder="**********">
                                                    <div id="settingsEmailHelp" class="form-text">As duas senha devem ser iguais</div>
                                                </div>
                                            </div>
                                            <div class="row m-t-lg">
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary m-t-sm">Atualizar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="settings-security-two-factor">
                                            <h5>Two-Factor Authentication</h5>
                                            <span>Two-factor authentication is automatically enabled on your account, for security reasons we require all users to authenticate with SMS code or authorized third-party auth apps. Read more about our security policy <a href="#">here</a>.</span>
                                        </div>
                                        <div class="row m-t-xxl">
                                            <div class="col-md-6">
                                                <label for="settingsCurrentPassword" class="form-label">Current Password</label>
                                                <input type="password" class="form-control" aria-describedby="settingsCurrentPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                                <div id="settingsCurrentPassword" class="form-text">Never share your password with anyone.</div>
                                            </div>
                                        </div>
                                        <div class="row m-t-xxl">
                                            <div class="col-md-6">
                                                <label for="settingsNewPassword" class="form-label">New Password</label>
                                                <input type="password" class="form-control" aria-describedby="settingsNewPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                            </div>
                                        </div>
                                        <div class="row m-t-xxl">
                                            <div class="col-md-6">
                                                <label for="settingsConfirmPassword" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" aria-describedby="settingsConfirmPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                            </div>
                                        </div>
                                        <div class="row m-t-xxl">
                                            <div class="col-md-6">
                                                <label for="settingsSmsCode" class="form-label">SMS Code</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" aria-describedby="settingsSmsCode" placeholder="&#9679;&#9679;&#9679;&#9679;">
                                                    <button class="btn btn-primary btn-style-light" id="settingsResentSmsCode">Resend</button>
                                                </div>
                                                <div id="settingsSmsCode" class="form-text">Code will be sent to the phone number from your account.</div>
                                            </div>
                                        </div>
                                        <div class="row m-t-lg">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="settingsPasswordLogout" checked>
                                                    <label class="form-check-label" for="settingsPasswordLogout">
                                                        Log out from all current sessions
                                                    </label>
                                                </div>
                                                <a href="#" class="btn btn-primary m-t-sm">Change Password</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="integrations" role="tabpanel" aria-labelledby="integrations-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="settings-integrations">
                                            <div class="settings-integrations-item">
                                                <div class="settings-integrations-item-info">
                                                    <img src="../../assets/images/icons/jira_software.png" alt="">
                                                    <span>Plan, track, and manage your agile and software development projects in Jira.</span>
                                                </div>
                                                <div class="settings-integrations-item-switcher">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input form-control-md" type="checkbox" id="settingsIntegrationOneSwitcher" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="settings-integrations-item">
                                                <div class="settings-integrations-item-info">
                                                    <img src="../../assets/images/icons/confluence.png" alt="">
                                                    <span>Build, organize, and collaborate on work in one place from virtually anywhere.</span>
                                                </div>
                                                <div class="settings-integrations-item-switcher">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input form-control-md" type="checkbox" id="settingsIntegrationTwoSwitcher" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="settings-integrations-item">
                                                <div class="settings-integrations-item-info">
                                                    <img src="../../assets/images/icons/bitbucket.png" alt="">
                                                    <span>Build, test, and deploy with unlimited private or public space with Bitbucket.</span>
                                                </div>
                                                <div class="settings-integrations-item-switcher">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input form-control-md" type="checkbox" id="settingsIntegrationThreeSwitcher">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="settings-integrations-item">
                                                <div class="settings-integrations-item-info">
                                                    <img src="../../assets/images/icons/sourcetree.png" alt="">
                                                    <span>A Git GUI that offers a visual representation of your repositories.</span>
                                                </div>
                                                <div class="settings-integrations-item-switcher">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input form-control-md" type="checkbox" id="settingsIntegrationFourSwitcher">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
