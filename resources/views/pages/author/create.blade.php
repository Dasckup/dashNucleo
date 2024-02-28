@extends('main._index')


@section('css')
<style>
    .buttom-submit {
     font-size: 12px;
     font-weight:600;
     padding:10px
    }

        .button-add-file{
        font-size: 12px;
        font-weight: 600;
        padding: 5px;
        margin-bottom: 25px;
    }

    .button-add-note{
        font-size: 12px;
        font-weight: 600;
        padding: 5px;
        margin-bottom: 25px;
    }

    .file-item-title{
        max-width: 340px;
        font-weight: 600!important;
        min-width: 339px;
        font-size: 12px!important;
    }


    #fileInput {
      display: none;
    }
    #fileDrop {
        padding: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e7ecf8;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        color: #535353;
        border: 3px dashed transparent;
        transition: all 0.3s ease;
    }

    #fileDrop:hover,
    #fileDrop.dragover {
      border-color: #ced5e1;
    }

    .title-form-upload-file{
        font-weight: 600;
        margin-bottom: 25px;
    }

    div.is-invalid-file + div.invalid-feedback {
      display: block;
    }


    .fileInfo-description{
        margin-left: 10px;
        display: flex;
        flex-direction: column;
    }

    .fileInfo-description-filename{
        font-size: 12px;
        font-weight: 600;
    }

    .fileInfo-description-filesize{
        font-size: 11px;
        color: #666;
    }

    .question-mark i{
        font-size: 8px;
        padding: 1px 1px 1px 1px;
        border-radius: 100%;
        color: var(--bs-primary);
        border: 1px solid var(--bs-primary);
        margin: 0px 0px 0px 0px;
    }

    .question-mark{
        user-select: none;
    }

    .popover-body{
        font-size: 12px;
    }

    .popover.bs-popover-end{
        margin-left: 4px!important;
    }
    .form-control:disabled, .form-control[readonly] {
        background-color: #e7e7e752;
        cursor: not-allowed;
    }
</style>
@endsection

@section('js')
<script src="{{custom_asset('/template/assets/js/viaCep.js')}}"></script>
<script src="{{custom_asset('/template/assets/js/input-mask/jquery.inputmask.min.js')}}"></script>
<script src="{{custom_asset("/template/assets/js/blockui.js")}}"></script>
<script src="{{custom_asset("/template/assets/js/CPFvalidador.js")}}"></script>

<script>
    $(document).ready(function() {
        $("#cpf").inputmask();
        $("#zipcode").inputmask();
        $("#cellphone").inputmask();
        $("#zipcode").on('blur', (e) => {
            setNewCepSearchField($("#zipcode"), ["address", "neighborhood", "city", "state", "complement", "ibge"]);
        })
    });
</script>

<script>
function handleDrop(event, inputId) {
    event.preventDefault();
    removeDragoverClass();
    validateAndShowFileInfo(event, inputId);
}

function clickFileInput(inputId) {
    document.getElementById(inputId).click();
}

function validateAndShowFileInfo(event, inputId) {
    const fileList = event.target.files || event.dataTransfer.files; // Handle both click and drop events

    const validExtensions = ['.docx', '.pdf', '.doc', '.jpeg', '.jpg', '.png'];
    const fileInfoContainer = document.getElementById(`${inputId}Preview`);
    const invalidFeedback = document.querySelector('.invalid-feedback');

    fileInfoContainer.innerHTML = '';

    for (let i = 0; i < fileList.length; i++) {
        const file = fileList[i];
        const fileName = file.name;
        const fileExtension = fileName.substring(fileName.lastIndexOf('.')).toLowerCase();
        const fileSizeKB = (file.size / 1024).toFixed(2);
        var icon = "description";

        if (([".jpg", ".jpeg", ".png"]).includes(fileExtension)) {
            icon = "image";
        }

        const html = `
            <div class="d-flex mt-3 align-items-center">
                <i class="material-symbols-outlined author-icons preview-icon-uploaded text-primary">${icon}</i>
                <div class="fileInfo-description">
                    <span class="fileInfo-description-filename">${fileName}</span>
                    <span class="fileInfo-description-filesize">${fileSizeKB}KB</span>
                </div>
            </div>
        `;

        if (validExtensions.includes(fileExtension)) {
            fileInfoContainer.innerHTML += html;
        } else {
            invalidFeedback.style.display = 'block';
            setTimeout(() => {
                invalidFeedback.style.display = 'none';
            }, 3000);
        }
    }
}

$("#on_brazil").on("change", function() {
    const nacionalFields = [
        "address",
        "number",
        "neighborhood",
        "complement",
        "ibge",
        "rg",
        "cpf"
    ];

    const internationalFields = [
        "addressline1",
        "addressline2",
        "country",
        "document"
    ];

    const nationalFieldsClass = $(".national-field");
    const internationalFieldsClass = $(".international-field");

    if ($(this).is(":checked")) {
        nacionalFields.forEach((field) => {
            $(`#${field}`).prop("disabled", false);
        });
        internationalFields.forEach((field) => {
            $(`#${field}`).prop("disabled", true);
        });
        nationalFieldsClass.show();
        internationalFieldsClass.hide();
        $("#cellphone").inputmask({ mask: "(99) 99999-9999" });
        $("#zipcode").inputmask({ mask: "99999-999" });
        $("#zipcode").on('blur', (e) => {
            setNewCepSearchField($("#zipcode"), ["address", "neighborhood", "city", "state", "complement", "ibge"]);
        })
    } else {
        $("#cellphone").inputmask('remove');
        $("#zipcode").inputmask('remove');
        $("#zipcode").off('blur');

        nacionalFields.forEach((field) => {
            $(`#${field}`).prop("disabled", true);
        });
        internationalFields.forEach((field) => {
            $(`#${field}`).prop("disabled", false);
        });
        nationalFieldsClass.hide();
        internationalFieldsClass.show();
    }
});

$("#with_submission").on("change", () => {
    $(".fileInputSubmission").prop("disabled", !$("#with_submission").is(":checked"));
    $("#submissionForm").toggle();
})

$("form[name='submition-store-author']").on("submit", function(event) {
    event.preventDefault();
    var form = $(this);

    if (form.valid()) {
        form.block({
            message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
        });

        var formData = new FormData(form[0]);
        var url = form.attr("action");
        var on_brazil = form.find("#on_brazil");
        var with_submission = form.find("#with_submission");

        if (on_brazil.is(':checked')) {
            formData.append('on_brazil' ,  true);
        }

        const fileInfoPhoto = event.target.fileInputPhotoUser.files[0];
        if(fileInfoPhoto){
            formData.append('file_photo', fileInfoPhoto);
            formData.append('size_photo', ((fileInfoPhoto.size / 1024).toFixed(2) + " KB"));
            formData.append('filename_photo', fileInfoPhoto.name);
        }

        const fileInfoSubmission = event.target.fileInputSubmission.files[0];

        if(with_submission.is(':checked')){
            if(fileInfoSubmission){
                event.target.fileInputSubmission.classList.remove('is-invalid');
                formData.append('file_submission', fileInfoSubmission);
                formData.append('size_submission', ((fileInfoSubmission.size / 1024).toFixed(2) + " KB"));
                formData.append('filename_submission', fileInfoSubmission.name);
            }else{
                event.target.fileInputSubmission.classList.add('is-invalid');
                $(form).unblock();
                return;
            }
        }

        formData.append('user', "{{Auth::user()->id}}");

        if (with_submission.is(':checked')) {
            formData.append('with_submission' ,  true);
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                form[0].reset();
                $(form).unblock();
                showCustomToast("success", {
                    title: "Sucesso!",
                    message: "Autor cadastrado com sucesso! <a href='" + response.link + "'>Visualizar</a>",
                });
            },
            error: function(response) {
                $(form).unblock();
                showCustomToast("error", {
                    title: "Opss!",
                    message: "Não foi possível atualizar os endereços: " + response.statusText,
                });
            }
        });
    }
});

$.validator.addMethod("validCpf", function(value, element) {
    return validarCPF(value);
}, "CPF deve ser valido");
$.validator.addMethod("validDateOfBirth", function(value, element) {
    var regex = /^\d{4}\-\d{2}\-\d{2}$/;
    if (!regex.test(value)) {
        return false;
    }

    // Verifica se a data é válida
    var parts = value.split('-');
    var day = parseInt(parts[2], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[0], 10);
    var dateOfBirth = new Date(year, month - 1, day);
    var currentDate = new Date();
    var age = currentDate.getFullYear() - dateOfBirth.getFullYear();
    var monthDiff = currentDate.getMonth() - dateOfBirth.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && currentDate.getDate() < dateOfBirth.getDate())) {
        age--;
    }

    console.log(age);
    return age > 5 && age < 150;
}, "Data de nascimento deve ser valida");
$.validator.addMethod("validCEP", function(value, element) {
    value = value.replace(/\D/g, '');
    return value.length === 8;
}, "CEP inválido");

$("form[name='submition-store-author']").validate({
    rules: {
        zipcode: {
            required: true,
            validCEP: $("#on_brazil").is(':checked')
        },
        name: "required",
        last_name: "required",
        ddi: {
            required: true,
            minlength: 2
        },
        birthday: {
            required: true,
            validDateOfBirth: true
        },
        email: {
            required: true,
            email: true
        },
        cellphone: {
            required: true,
            minlength: 5
        },
        where_finded: "required",
        area: "required",
        city: "required",
        state: "required",
        cpf: {
            required: function() {
                return $("#on_brazil").is(':checked');
            },
            validCpf: $("#on_brazil").is(':checked')
        },
        rg: {
            required: function() {
                return $("#on_brazil").is(':checked');
            }
        },
        street: {
            required: function() {
                return $("#on_brazil").is(':checked');
            }
        },
        address: {
            required: function() {
                return $("#on_brazil").is(':checked');
            }
        },
        number: {
            required: function() {
                return $("#on_brazil").is(':checked');
            }
        },
        neighborhood: {
            required: function() {
                return $("#on_brazil").is(':checked');
            }
        },
        addressline1: {
            required: function() {
                return !$("#on_brazil").is(':checked');
            }
        },
        country: {
            required: function() {
                return !$("#on_brazil").is(':checked');
            }
        }
    },
    errorPlacement: function(error, element) {
        $(element).removeClass('is-valid').addClass('is-invalid');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid').addClass('is-valid');
    }
});


</script>




@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">

                <div class="row">
                    <div class="col">
                        <div class="page-description pt-2 ps-0 pb-0 border-0">
                            <h1 class="text-captalize">Novo autor <span style="display: none" class="text-primary international-field">internacional</span></h1>
                            <span style="margin-top: 10px;">Cadastrar um novo autor para o banco de autores.</span>
                        </div>
                    </div>
                </div>

                <form name="submition-store-author" method="POST" action="{{route('author.store')}}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card">
                                <div id="blockui-card-1" class="card-body">


                                        <div class="col-sm-12 m-b-xxl">
                                            <div class="mb-2 form-check form-check-inline">
                                                <input checked="true" class="form-check-input" type="checkbox" id="with_submission">
                                                <label class="form-check-label form-label" for="with_submission">Cadastrar submissão</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input checked="true" class="form-check-input" type="checkbox" id="on_brazil">
                                                <label class="form-check-label form-label" for="on_brazil">O autor está no Brasil</label>
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-sm-6">
                                                <label class="form-label w-100">
                                                    Clique aqui ou arraste e solte a foto do autor (opicional)
                                                </label>
                                                <div>
                                                    <div data-bs-from="fileInputPhotoUser" id="fileDrop" ondrop="handleDrop(event, 'fileInputPhotoUser')" ondragover="allowDrop(event)" ondragenter="addDragoverClass()" ondragleave="removeDragoverClass()" onclick="clickFileInput('fileInputPhotoUser')">
                                                        <span class="material-symbols-outlined" style="font-size: 35px;color: #666;">
                                                            upload_file
                                                        </span>
                                                        <input data-bs-from="fileInputPhotoUser" type="file" id="fileInputPhotoUser" name="fileInputPhotoUser" onchange="validateAndShowFileInfo(event, 'fileInputPhotoUser')" accept=".docx, .pdf, .doc, .jpeg, .jpg, .png"  style="display: none;">
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        O documento deve ser no formato ( jpeg, jpg, png )
                                                    </div>
                                                </div>
                                                <div class="fileInfo" id="fileInputPhotoUserPreview">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="m-b-xxl">
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <label class="form-label" for="name">Nome <code>*</code></label>
                                                    <input placeholder="Primeiro nome" id="name" name="name" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-label" for="name">Sobrenome <code>*</code></label>
                                                    <input placeholder="Sobrenome" id="last_name" name="last_name" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label" for="email">Email <code>*</code></label>
                                                    <input placeholder="exemplo@exemplo.com" id="email" name="email" type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-2">
                                                    <label class="form-label" for="ddi">DDI <code>*</code></label>
                                                    <input value="+55" placeholder="DDI" id="ddi" name="ddi" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="form-label" for="cellphone">Celular <code>*</code></label>
                                                    <input data-inputmask="'mask': '(99) 99999-9999'" id="cellphone" name="cellphone" type="text" class="form-control">
                                                </div>


                                                <div class="col-sm-3 national-field">
                                                    <label class="form-label" for="cpf">CPF <code>*</code></label>
                                                    <input placeholder="000.000.000-00" data-inputmask="'mask': '999.999.999-99'" id="cpf" name="cpf" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-3 national-field">
                                                    <label class="form-label" for="rg">RG <code>*</code></label>
                                                    <input placeholder="00.000.000-00" id="rg" name="rg" type="text" class="form-control">
                                                </div>

                                                <div style="display: none" class="col-sm-6 international-field">
                                                    <label class="form-label" for="document">Documento (opicional)</label>
                                                    <input disabled="true" id="document" name="document" type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-label" for="birthday">Data de nascimento <code>*</code></label>
                                                    <input id="birthday" name="birthday" type="date" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row m-b-xxl">
                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <label class="form-label" for="zipcode">CEP / Código Postal <code>*</code></label>
                                                    <input data-inputmask="'mask': '99999-999'" placeholder="0000-000" id="zipcode" name="zipcode" type="text" class="form-control">
                                                </div>
                                                <div style="display: none" class="col-sm-8 international-field">
                                                    <label class="form-label" for="country">País em que vive <code>*</code></label>
                                                    <select disabled="true" style="font-size: 12px" class="form-select"  id="country" name="country">
                                                        @include('pages.author.componets.options._countries')
                                                    </select>
                                                </div>
                                            </div>

                                            <div style="display: none" class="international-field row mb-3">
                                                <div class="col-sm-6">
                                                    <label class="form-label" for="addressline1">Linha de endereço 1 <code>*</code></label>
                                                    <input disabled="true" placeholder="Rua exemplo, N 23, bairro centro" id="addressline1" name="addressline1" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label" for="addressline2">Linha de endereço 2 </label>
                                                    <input disabled="true" placeholder="Rua exemplo, N 23, bairro centro" id="addressline2" name="addressline2" type="text" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-4">
                                                    <label class="form-label" for="city">Cidade <code>*</code></label>
                                                    <input placeholder="Cidade" id="city" name="city" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="form-label" for="uf">Estado <code>*</code></label>
                                                    <input  id="state" name="state" type="text" class="form-control">
                                                </div>


                                                <div class="col-sm-4 national-field">
                                                    <label class="form-label" for="address">Endereço <code>*</code></label>
                                                    <input placeholder="Rua, Avnd" id="address" name="address" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-2 national-field">
                                                    <label class="form-label" for="number">Número <code>*</code></label>
                                                    <input id="number" name="number" type="text" class="form-control">
                                                </div>
                                            </div>

                                            <!--- ONLY ON BRAZIL MODE --->
                                            <div class="row mb-3 national-field">
                                                <div class="col-sm-3 national-field">
                                                    <label class="form-label" for="ibge">IBGE <code>*</code>
                                                        <a
                                                        class="question-mark"
                                                        data-bs-container="body"
                                                        data-bs-toggle="popover"
                                                        data-bs-placement="right"
                                                        data-bs-content="IBGE se constitui no principal provedor de dados e informações do País">
                                                            <i class="material-icons">question_mark</i>
                                                        </a>
                                                    </label>
                                                    <input id="ibge" name="ibge" type="text" class="form-control" readonly>
                                                </div>
                                                <div class="col-sm-4 national-field">
                                                    <label class="form-label" for="neighborhood"> Bairro <code>*</code></label>
                                                    <input id="neighborhood" name="neighborhood" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-5 national-field">
                                                    <label class="form-label" for="complement">Complemento </label>
                                                    <input placeholder="apto 1, casa frente, rua b" id="complement" name="complement" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row m-b-xxl">
                                            <div class="row mb-3">
                                                <div class="col-sm-6">
                                                    <label class="form-label" for="where_finded">Onde encontrou nossa Revista Científica?  <code>*</code></label>
                                                    <select style="font-size: 12px" id="where_finded" name="where_finded" type="text" class="form-select">
                                                        <option value="">
                                                        Selecione
                                                        </option>
                                                        <option value="Instagram">
                                                        Instagram
                                                        </option>
                                                        <option value="E-mail">
                                                        E-mail
                                                        </option>
                                                        <option value="Indicação do professor">
                                                        Indicação do professor
                                                        </option>
                                                        <option value="Google / Pesquisa">
                                                        Google / Pesquisa
                                                        </option>
                                                        <option value="Whastapp">
                                                        Whastapp
                                                        </option>
                                                        <option value="Facebook">
                                                        Facebook
                                                        </option>
                                                        <option value="Formulário em website">
                                                        Formulário em website
                                                        </option>
                                                        <option value="youtube">
                                                        Youtube
                                                        </option>
                                                        <option value="linkedin">
                                                        Linkedin
                                                        </option>
                                                        <option value="WhatsApp - Celular - Revista">
                                                        WhatsApp - Celular - Revista
                                                        </option>
                                                        <option value="outro">
                                                        Outro
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label" for="area">Selecione sua área  <code>*</code></label>
                                                    <select style="font-size: 12px" id="area" name="area" type="text" class="form-select">
                                                        <option value="">Selecione</option>
                                                        <option value="Administração">Administração</option>
                                                        <option value="Administração Naval">Administração Naval</option>
                                                        <option value="Agronomia">Agronomia</option>
                                                        <option value="Arquitetura">Arquitetura</option>
                                                        <option value="Arte">Arte</option>
                                                        <option value="Biologia">Biologia</option>
                                                        <option value="Ciência da Computação">Ciência da Computação</option>
                                                        <option value="Ciência da Religião">Ciência da Religião</option>
                                                        <option value="Ciências Aeronáuticas">Ciências Aeronáuticas</option>
                                                        <option value="Ciências Sociais">Ciências Sociais</option>
                                                        <option value="Comunicação">Comunicação</option>
                                                        <option value="Contabilidade">Contabilidade</option>
                                                        <option value="Educação">Educação</option>
                                                        <option value="Educação Física">Educação Física</option>
                                                        <option value="Engenharia Agrícola">Engenharia Agrícola</option>
                                                        <option value="Engenharia Ambiental">Engenharia Ambiental</option>
                                                        <option value="Engenharia Civil">Engenharia Civil</option>
                                                        <option value="Engenharia da Computação">Engenharia da Computação</option>
                                                        <option value="Engenharia de Produção">Engenharia de Produção</option>
                                                        <option value="Engenharia Elétrica ">Engenharia Elétrica</option>
                                                        <option value="Engenharia Mecânica ">Engenharia Mecânica</option>
                                                        <option value="Engenharia Química ">Engenharia Química</option>
                                                        <option value="Ética">Ética</option>
                                                        <option value="Filosofia">Filosofia</option>
                                                        <option value="Física">Física</option>
                                                        <option value="Gastronomia">Gastronomia</option>
                                                        <option value="Geografia">Geografia</option>
                                                        <option value="História">História</option>
                                                        <option value="Lei">Lei</option>
                                                        <option value="Letras">Letras</option>
                                                        <option value="Literatura">Literatura</option>
                                                        <option value="Marketing">Marketing</option>
                                                        <option value="Matemática">Matemática</option>
                                                        <option value="Meio Ambiente">Meio Ambiente</option>
                                                        <option value="Meteorologia">Meteorologia</option>
                                                        <option value="Nutrição">Nutrição</option>
                                                        <option value="Odontologia">Odontologia</option>
                                                        <option value="Pedagogia">Pedagogia</option>
                                                        <option value="Psicologia">Psicologia</option>
                                                        <option value="Química">Química</option>
                                                        <option value="Saúde">Saúde</option>
                                                        <option value="Sem categoria">Sem categoria</option>
                                                        <option value="Sociologia">Sociologia</option>
                                                        <option value="Tecnologia">Tecnologia</option>
                                                        <option value="Teologia">Teologia</option>
                                                        <option value="Turismo">Turismo</option>
                                                        <option value="Veterinária">Veterinária</option>
                                                        <option value="Zootecnia">Zootecnia</option>
                                                        <option value="outro">Outro</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary buttom-submit">Cadastrar autor e submissão</button>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div id="submissionForm" class="card">
                                <div id="blockui-card-1" class="card-body">
                                        @csrf
                                        <div class="m-b-xxl">
                                            <h5 class="card-title">Dados da submissão</h5>
                                            <p style=" font-size: 12px; " class="card-text">Atenção após o cadastrado a cadeia de processos será iniciado para essa submissão</p>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="form-label w-100">
                                                    Clique aqui ou arraste e solte o arquivo <code>*</code>
                                                </label>
                                                <div class="position-relative" id="fileDrop" ondrop="handleDrop(event, 'fileInputSubmission')" ondragover="allowDrop(event)" ondragenter="addDragoverClass()" ondragleave="removeDragoverClass()" onclick="clickFileInput('fileInputSubmission')">
                                                    <span class="material-symbols-outlined" style="font-size: 35px;color: #666;">
                                                        upload_file
                                                    </span>
                                                    <input  type="file" id="fileInputSubmission" name="fileInputSubmission" onchange="validateAndShowFileInfo(event, 'fileInputSubmission')" accept=".docx, .pdf, .doc, .jpeg, .jpg, .png"  style="display: none;">
                                                    <div style=" bottom: 0px; right: -19px; " class="invalid-feedback position-absolute">O documento deve ser no formato ( docx, doc, pdf )</div>
                                                </div>
                                                <div class="fileInfo" id="fileInputSubmissionPreview">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

