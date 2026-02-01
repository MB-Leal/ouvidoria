@component('mail::message')
# Olá, {{ $manifestacao->nome ?? 'Cidadão' }}

Esta é uma mensagem da **Ouvidoria FASPM/PA**.

Sua manifestação foi registrada/atualizada com sucesso em nosso sistema.

**Dados para Acompanhamento:**
@component('mail::panel')
**Protocolo:** {{ $manifestacao->protocolo }}  
@if($chave)
**Chave de Acesso (Token):** {{ $chave }}
@endif
@endcomponent

@if($chave)
*Importante: Guarde sua Chave de Acesso. Ela é necessária para consultar o andamento da sua manifestação em nosso portal.*
@endif

**Assunto:** {{ $manifestacao->assunto }}  
**Status Atual:** {{ $manifestacao->status }}

@component('mail::button', ['url' => route('manifestacoes.acompanhar')])
Acompanhar no Portal
@endcomponent

@component('mail::subcopy')
Seus dados são tratados em conformidade com a Lei Geral de Proteção de Dados (Lei nº 13.709/2018).
@endcomponent

Atenciosamente,<br>
**Equipe de Ouvidoria - FASPM/PA**
@endcomponent