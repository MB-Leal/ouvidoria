<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Manifestacao;

class ManifestacaoRecebida extends Mailable
{   
    use Queueable, SerializesModels;

    public $manifestacao;
    public $chave;
    public $assuntoPersonalizado;

    /**
     * @param Manifestacao $manifestacao
     * @param string|null $chave Chave aleatória (X7A9FQ2) - enviada apenas na criação
     * @param string|null $assunto Caso queira mudar o assunto do e-mail
     */
    public function __construct(Manifestacao $manifestacao, $chave = null, $assunto = null)
    {
        $this->manifestacao = $manifestacao;
        $this->chave = $chave;
        $this->assuntoPersonalizado = $assunto ?? "Atualização de Manifestação - Protocolo: {$manifestacao->protocolo}";
    }

    public function build()
    {
        return $this->subject($this->assuntoPersonalizado)
                    ->markdown('emails.manifestacoes.recebida');
    }
}
