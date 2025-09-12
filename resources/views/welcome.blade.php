@extends('layouts.app')

@section('content')
    <div class="accordion container mb-5 mt-5 pt-5" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h5>Ouvidoria</h5>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show bg-primary" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body text-center ">
                    <p class="text-light border-bottom"><strong>Bem-vindo a Ouvidoria do Fundo de Assistência Social da PMPA!</strong></p>
                    <p class="text-light ">Criado por determinação legal para ser um canal de comunicação entre o público e este órgão.</p>
                    <p class="text-light">Aqui é possível encaminhar elogios, sugestões, críticas, reclamações, pedido de informações, esclarecimentos e orientações a respeito das nossas ações.</p>
                    <p class="text-light">Este canal é exclusivo para estes assuntos, apenas o ouvidor terá acesso às informações encaminhadas através do formulário preenchido nesta página, garantido por lei o sigilo dos dados pessoais e das informações prestadas. A participação de todos os policiais militares, bombeiros associados e seus dependentes é essencial para construir um novo FASPM, sendo útil para mensurar nossa atuação. Esse feedback nos dá condições de avaliar onde precisamos melhorar, e se estamos acertando, para realinhar nossas metodologias.</p>
                </div>
            </div>
        </div>
        <div class="accordion-item ">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <h5>Missão - Visão</h5>
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse bg-primary" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body text-center">
                    <p class="text-light"><strong>Missão</strong></p>
                    <p class="text-light">Exercer o Controle Interno assessorando o Gestor máximo (Diretor) em benefício do órgão, orientando, acompanhando e fiscalizando a efetiva e regular gestão dos recursos públicos estaduais e próprios.</p>
                    <p class="text-light"><strong>Visão</strong></p>
                    <p class="text-light">Ser reconhecido pelo público-alvo (associados) e pelos Órgãos de Controle Externo como Órgão de excelência no Controle Interno e no aperfeiçoamento da gestão pública estadual.</p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree ">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <h5>Carta de serviço</h5>
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse bg-primary" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body text-center">
                    <a href="https://faspmpa.com.br/wp-content/uploads/Carta-de-Servicos-ao-Usuario.pdf" class="text-light">Visualizar</a>
                </div>
            </div>
        </div>
    </div>


    <section class="container mb-5 d-flex justify-content-around overflow-hidden">
        <div class="row w-100 d-flex justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                <div class="card d-flex" style="width: 18rem;">
                    <img src="{{ asset('assets/imgs/ouvidoria.jpg') }}" class="card-img-top" alt="..." style="height: 150px;">
                    <div class="card-body mb-md-7">
                        <h5 class="card-title">Nova Demanda</h5>
                        <p class="card-text text-muted">Quando a demanda for relacionada a um serviço prestado pela FASPM.</p>
                        <a href="{{ route('demanda.create', ['tipo' => 'reclamacao']) }}" class="btn btn-primary"><i class="fa-solid fa-plus justify-content-center"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('assets/imgs/pesquisa-ouvidoria.png') }}" class="card-img-top" alt="..." style="height: 150px;">
                    <div class="card-body">
                        <h5 class="card-title">Consultar Demanda</h5>
                        <p class="card-text text-muted">Possibilita visualizar informações sobre demanda anteriormente cadastrada.</p>
                        <a href="{{ route('demanda.consultar') }}" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center" id="card-auto-altura">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('assets/imgs/relatorios.png') }}" class="card-img-top" alt="..." style="height: 150px;">
                    <div class="card-body">
                        <h5 class="card-title">Relatório de Demandas</h5>
                        <a href="{#}" class="btn btn-primary"><i class="bi bi-file-earmark-bar-graph-fill"></i></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5 overflow-hidden">
        <div class="row border-blue_fas">

            <div class="col-12 d-flex flex-column justify-content-around w-100 text-center bg-blue_fas" style="height: 100px;">
                <h2 class="text-light">Canais de Atendimento</h2>
            </div>

            <div class="col-lg-3 col-sm-6 d-flex flex-column p-4 justify-content-around text-center " style="height: 200px;">
                <i class="fa-solid fa-phone icons-canais" style="font-size: 40px;"></i>
                <h3>Telefone</h3>
                <a title="CHAMADA DE VOZ" href="tel:(091)32513163" target="_blank" rel="noopener noreferrer">
                    <p class="text-canais">91 3251 3163</p>
                </a>
            </div>

            <div class="col-lg-3 col-sm-6 d-flex flex-column p-4 justify-content-around text-center " style="height: 200px;">
                <i class="fa-regular fa-envelope" style="font-size: 40px;"></i>
                <h3>E-mail</h3>
                <a title="ENVIAR E-MAIL" href="mailto:ouvidoria@faspmpa.com.br" target="_blank">
                    <p class="text-canais">ouvidoria@faspmpa.com.br</p>
                </a>
            </div>

            <div class="col-lg-3 col-sm-6 d-flex flex-column p-md-4 justify-content-around text-center " style="height: 200px;">
                <i class="fa-brands fa-whatsapp" style="font-size: 40px;"></i>
                <h3>Whatsapp</h3>
                <a href="https://wa.me/5591325131632" target="_blank">
                    <p class="text-canais">91 3251 3163.</p>
                </a>
            </div>

            <div class="col-lg-3 col-sm-6 d-flex flex-column p-4 justify-content-around text-center" style="height: 200px;">
                <i class="fa-solid fa-location-dot" style="font-size: 40px;"></i>
                <h3>Presencial</h3>
                <div>
                    <a href="https://www.google.com.br/maps/place/Tv.+Nove+de+Janeiro,+2600+-+Crema%C3%A7%C3%A3o,+Bel%C3%A9m+-+PA,+66065-155/@-1.4630796,-48.4775393,17z/data=!3m1!4b1!4m5!3m4!1s0x92a48dd4274c45e9:0x3b50626ef02cf4c4!8m2!3d-1.463085!4d-48.4753506" target="_blank">
                        <span class="text-canais">Tv. 9 de janeiro, 2600, </span>
                        <span class="text-canais"> Cremação,Belém.</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="informacao" class="mb-5 container overflow-hidden">
        <p>
            Os dados ofertados têm por finalidade o atendimento das demandas e a geração de estatísticas sobre as
            atividades da Ouvidoria e serão tratados conforme a legislação aplicável – em especial:
        </p>
        <p>A Lei de Acesso à Informação (Lei nº 12.527/2011);</p>
        <p>A Lei de Proteção e Defesa do Usuário dos Serviços Públicos (Lei nº 13.460/2017);</p>
        <p>A Lei Geral de Proteção de Dados (Lei nº 13.709/2018).</p>
    </section>
@endsection