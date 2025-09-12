<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandaRegistrada extends Notification
{
     use Queueable;

    protected $demanda;

    public function __construct(Demanda $demanda)
    {
        $this->demanda = $demanda;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Confirmação de Registro de Demanda - Ouvidoria')
                    ->greeting('Olá!')
                    ->line('Sua demanda foi registrada com sucesso em nossa Ouvidoria.')
                    ->line('Acompanhe o andamento da sua manifestação utilizando o número de protocolo abaixo.')
                    ->line('Número de Protocolo: ' . $this->demanda->protocolo)
                    ->action('Consultar Demanda', url('/consultar-demanda'))
                    ->line('Obrigado por sua colaboração!')
                    ->salutation('Atenciosamente, Equipe da Ouvidoria.');
    }
}
