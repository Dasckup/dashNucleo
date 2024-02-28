function setNewCepSearchField(cepEl, fields = []) {
    const VIA_CEP_URL = "https://viacep.com.br/ws/";
    const CEP_REGEX = /^[0-9]{8}$/;
    function clearFields() {
        cepEl.removeClass("is-invalid");
        fields.forEach((field) => {
            $("#" + field).val("");
        });
    }

    function isValidCep(cep) {
        return CEP_REGEX.test(cep);
    }

    function setValue(values) {
        Object.entries(values).forEach(([key, value]) => {
            const el = $("#" + key);
            if (el.length && fields.includes(key)) {
                el.val(value);
                if (key == "neighborhood") {
                    el.prop("readonly", el.val() != "");
                }
            }
        });
    }

    clearFields();
    const cep = cepEl.val().replace(/\D/g, "");

    if (cep) {
        if (isValidCep(cep)) {
            $.getJSON(
                VIA_CEP_URL + cep + "/json/?callback=?",
                function (dados) {
                    if (!("erro" in dados)) {
                        const addressData = {
                            address: dados.logradouro,
                            neighborhood: dados.bairro,
                            city: dados.localidade,
                            state: dados.uf,
                            complement: dados.complemento,
                            ibge: dados.ibge,
                        };
                        setValue(addressData);
                    } else {
                        cepEl.addClass("is-invalid");
                        clearFields();
                    }
                }
            );
        } else {
            cepEl.addClass("is-invalid");
            clearFields();
        }
    }
}
