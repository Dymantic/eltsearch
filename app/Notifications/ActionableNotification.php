<?php


namespace App\Notifications;


interface ActionableNotification
{
    public function getSubjectFor($notifiable): string;

    public function getMessageFor($notifiable): string;

    public function actionTextFor($notifiable): string;

    public function actionUrl($notifiable): string;
}
