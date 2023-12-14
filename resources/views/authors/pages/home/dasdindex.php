<table id="myMaterials" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width:0%;" class="text-center d-none">#</th>
                                        <th style="width:35%">{{__('messages.datatable.home.labels.material')}}</th>
                                        <th style="width:35%">{{__('messages.datatable.home.labels.product')}}</th>
                                        <th style="width:20%" >{{__('messages.datatable.home.labels.date_submission')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clientSubmissions as $client)
                                        <?php
                                            $name = explode(' ', mb_convert_case($client->name, MB_CASE_TITLE, "UTF-8"))[0];
                                            $email = $client->email != null? $client->email : "Não informado";

                                            $extentions = explode('.', $client->material->url_material);
                                            $extention = end($extentions);
                                        ?>
                                        <tr>
                                            <td class="d-none">{{$client->id}}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <img width="45px" height="45px" src="{{asset('/template/assets/images/icons/'.$extention.'-icon.png')}}">
                                                    </div>
                                                    <div class="ms-3 d-flex flex-column">
                                                        <div class="text-black title-row-in-table">{{$client->material->name_material}}</div>
                                                        <div class="sub-title-row-in-table">{{$client->material->size_material}}</div>
                                                    </div>
                                                    <a class="ms-3" href="{{route("AppAuthor.material.show", ["id"=>$client->id])}}">
                                                        <span class="material-symbols-outlined">
                                                            bubble
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                @if($client->submission)
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table">
                                                            {{$client->submission->term_publication_title}}
                                                        </p>
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex align-items-center">
                                                            @if(!str_contains($client->submission->term_publication_price,"BRL"))
                                                                <i title="internacional" class="material-icons text-gray" style=" font-size: 16px; margin-right:4px">public</i>
                                                            @endif
                                                            {{$client->submission->term_publication_price}}
                                                        </p>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table">{{date("d/m/Y", strtotime($client->created_at))}}</p>
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table">{{date("\á\s H:i", strtotime($client->created_at))}}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
