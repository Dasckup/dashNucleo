
<button style="padding:6px" class="btn btn-primary button-submit mb-3">Nova submissão</button>
@foreach ($author->article as $article)
    <div class="card-submissions-item d-flex flex-row justify-content-between">
        <div class="d-flex align-items-center">
            <div class="dropdown me-3">
                <a style="
                    color: #ffc107;
                    border-color: #ffc107;
                    " class="btn border-2 dropdown-button-choose-status bg-transparent  dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    pendente
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li>
                        <a class="dropdown-item  dropdown-item-select-status-client d-flex align-items-center" style="color:#e3504b" data-slug="pendencias" data-value="2" data-to="593">
                            <i class="material-icons me-2" style="font-size: 19px">error</i> Com Pendências
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item  dropdown-item-select-status-client d-flex align-items-center" style="color:#0d6efd" data-slug="atendidos" data-value="3" data-to="593">
                            <i class="material-icons me-2" style="font-size: 19px">phone_callback</i> Em Atendimento
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item  dropdown-item-select-status-client d-flex align-items-center" style="color:#0dcaf0" data-slug="aceitos" data-value="4" data-to="593">
                            <i class="material-icons me-2" style="font-size: 19px">assignment_turned_in</i> Aceitos
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item  dropdown-item-select-status-client d-flex align-items-center" style="color:#dc3545" data-slug="recusados" data-value="5" data-to="593">
                            <i class="material-icons me-2" style="font-size: 19px">content_paste_off</i> Recusados
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item  dropdown-item-select-status-client d-flex align-items-center" style="color:#d63384" data-slug="pagamento_pendentes" data-value="6" data-to="593">
                            <i class="material-icons me-2" style="font-size: 19px">currency_exchange</i> Pagamentos Pendentes
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item  dropdown-item-select-status-client d-flex align-items-center" style="color:#198754" data-slug="pagas" data-value="7" data-to="593">
                            <i class="material-icons me-2" style="font-size: 19px">paid</i> Pagos
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item  dropdown-item-select-status-client d-flex align-items-center" style="color:#6c757d" data-slug="cancelados" data-value="8" data-to="593">
                            <i class="material-icons me-2" style="font-size: 19px">cancel</i> Cancelados
                        </a>
                    </li>
                </ul>
            </div>
            <div class="me-3">
                <p class="m-0 text-black title-row-in-table">Submissão #{{ $article->id }}</p>
                <div>
                    <ul class="d-flex p-0 m-0 " style="list-style: none">
                        <li class="me-2">
                            <a style="text-decoration: none" target="_blank" href="#">
                                <span class="badge-count-information-submitions badge badge-style-bordered rounded-pill">
                                    <span style="font-size: 12px" class="material-symbols-outlined me-1">
                                        description
                                    </span>
                                    <span>5</span>
                                </span>
                            </a>
                        </li>
                        <li class="me-2">
                            <a style="text-decoration: none" target="_blank" href="#">
                                <span class="badge-count-information-submitions badge badge-style-bordered rounded-pill">
                                    <span style="font-size: 12px" class="material-symbols-outlined me-1">
                                        note
                                    </span>
                                    <span>5</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <a class="link-to-open-submition" href="#">
                    <i class="material-symbols-outlined text-gray" >bubble</i>
                </a>
            </div>
        </div>
        <div>
            <div class="d-flex align-items-center">
                <div>
                    <i class="material-icons-outlined text-primary align-middle m-r-sm">description</i>
                </div>
                <div class="d-flex flex-column me-3">
                    <a target="_blank" href="#" class="file-item-title flex-fill">
                        Artigo_sibele.docx
                    </a>
                    <span style="font-size: 11px;">
                        <span>
                            Enviado pelo autor <b class="text-transform-capitalize">Sibele</b>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div>
            <p class="m-0 text-black title-row-in-table">Nenhum prazo definido</p>
            <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex align-items-center">
                0.0
            </p>
        </div>
        <div>
            <p class="m-0 text-black title-row-in-table">16/02/2024</p>
            <p style="font-weight:500" class="m-0 sub-title-row-in-table">ás 09:11</p>
        </div>
    </div>
@endforeach
